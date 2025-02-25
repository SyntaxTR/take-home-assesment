<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\OrderDiscount;
use App\Services\Discounts\DiscountService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $orders = Order::with('items', 'discounts')->get();
        $formattedOrders = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'customerId' => $order->customer_id,
                'items' => $order->items->map(function ($item) {
                    return [
                        'productId' => $item->product_id,
                        'quantity' => $item->quantity,
                        'unitPrice' => number_format($item->unit_price, 2),
                        'total' => number_format($item->total, 2),
                    ];
                }),
                'total' => number_format($order->items->sum('total'), 2),
                'discounts' => $order->discounts->map(function ($discount) use ($order) {
                    return [
                        'discountReason' => $discount->discount_reason,
                        'discountAmount' => number_format($discount->discount_amount, 2),
                        'subtotal' => number_format($order->items->sum('total') - $discount->discount_amount, 2)
                    ];
                }),
                'finalTotal' => number_format($order->items->sum('total') - $order->discounts->sum('discount_amount'), 2)
            ];
        });
        return response()->json($formattedOrders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, DiscountService $discountService)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'customer_id' => $validated['customer_id']
        ]);

        $total = 0;
        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);

            if ($product->stock < $item['quantity']) {
                return response()->json([
                    'message' => "Ürün stokta yetersiz: {$product->name}. Mevcut stok: {$product->stock}"
                ], 400);
            }

            $unitPrice = $product->price;
            $totalPrice = $unitPrice * $item['quantity'];

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'unit_price' => $unitPrice,
                'total' => $totalPrice,
            ]);

            $product->decrement('stock', $item['quantity']);

            $total += $totalPrice;
        }

        $discounts = $discountService->apply($order);
        $totalAfterDiscount = $total - $discounts['total_discount'];

        foreach ($discounts['discounts'] as $discount) {
            OrderDiscount::create([
                'order_id' => $order->id,
                'discount_reason' => class_basename($discount['rule']),
                'discount_amount' => $discount['discount']
            ]);
        }

        $formattedDiscounts = collect($discounts['discounts'])->map(function ($discount) use ($totalAfterDiscount) {
            return [
                'discountReason' => class_basename($discount['rule']),
                'discountAmount' => number_format($discount['discount'], 2),
                'subtotal' => number_format($discount['subtotal'], 2)
            ];
        });

        return response()->json([
            'message' => 'Sipariş başarıyla oluşturuldu.',
            'order' => $order->load('items'),
            'total' => number_format($total, 2),
            'total_discount' => number_format($discounts['total_discount'], 2),
            'final_total' => number_format($totalAfterDiscount, 2),
            'applied_discounts' => $formattedDiscounts
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Order $order)
    {
        return response()->json($order);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Order $order) {
        $order->update($request->validate([
            'customer_id' => 'required|exists:customers,id',
        ]));

        return response()->json($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}
