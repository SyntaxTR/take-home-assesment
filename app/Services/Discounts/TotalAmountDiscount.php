<?php
namespace App\Services\Discounts;

use App\Models\Order;

class TotalAmountDiscount implements DiscountInterface
{
    public function apply(Order $order): float
    {
        $total = $order->items->sum('total');

        if ($total >= 1000) {
            return $total * 0.10; // %10 indirim
        }

        return 0;
    }
}
