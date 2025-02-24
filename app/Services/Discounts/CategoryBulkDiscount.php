<?php
namespace App\Services\Discounts;

use App\Models\Order;

class CategoryBulkDiscount implements DiscountInterface
{
    public function apply(Order $order): float
    {
        $discount = 0;

        foreach ($order->items as $item) {
            if ($item->product->categoryId == 2 && $item->quantity >= 6) {
                $discount += $item->product->price; // 1 ürün bedava
            }
        }

        return $discount;
    }
}
