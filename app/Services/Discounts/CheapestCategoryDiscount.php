<?php

namespace App\Services\Discounts;

use App\Models\Order;

class CheapestCategoryDiscount implements DiscountInterface
{
    public function apply(Order $order): float
    {
        $products = $order->items->filter(fn($item) => $item->product->categoryId == 1);

        if ($products->count() >= 2) {
            $cheapest = $products->sortBy('product.price')->first();
            return $cheapest->product->price * 0.20; // En ucuz ürüne %20 indirim
        }

        return 0;
    }

    public function getRuleName(): string
    {
        return "CHEAPEST_CATEGORY_DISCOUNT";
    }
}
