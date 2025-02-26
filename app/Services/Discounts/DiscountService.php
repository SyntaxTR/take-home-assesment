<?php
namespace App\Services\Discounts;

use App\Models\Order;

class DiscountService
{
    protected array $discounts = [];

    public function __construct()
    {

        $this->discounts = [
            new TotalAmountDiscount(),
            new CategoryBulkDiscount(),
            new CheapestCategoryDiscount(),
        ];
    }

    public function apply(Order $order)
    {
        $currentTotal = $order->items->sum('total');
        $discounts = [];
        $totalDiscount = 0;

        foreach ($this->discounts as $rule) {
            $discountAmount = $rule->apply($order);

            if ($discountAmount > 0) {
                $totalDiscount += $discountAmount;
                $currentTotal -= $discountAmount;

                $discounts[] = [
                    'rule' => $rule->getRuleName(),
                    'discount' => $discountAmount,
                    'subtotal' => $currentTotal
                ];
            }
        }

        return [
            'discounts' => $discounts,
            'total_discount' => $totalDiscount,
            'discountedTotal' => $currentTotal
        ];
    }
}
