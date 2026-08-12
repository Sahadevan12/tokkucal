<?php

namespace App\Services;

class DiscountCalculatorService
{
    /**
     * @return array{original_price: float, discount_percent: float, discount_amount: float, final_price: float}
     */
    public function fromPercent(float $originalPrice, float $discountPercent): array
    {
        $discountAmount = round($originalPrice * $discountPercent / 100, 2);

        return [
            'original_price' => round($originalPrice, 2),
            'discount_percent' => $discountPercent,
            'discount_amount' => $discountAmount,
            'final_price' => round($originalPrice - $discountAmount, 2),
        ];
    }

    /**
     * @return array{original_price: float, sale_price: float, discount_amount: float, discount_percent: float}
     */
    public function fromSalePrice(float $originalPrice, float $salePrice): array
    {
        $discountAmount = round($originalPrice - $salePrice, 2);

        return [
            'original_price' => round($originalPrice, 2),
            'sale_price' => round($salePrice, 2),
            'discount_amount' => $discountAmount,
            'discount_percent' => round($discountAmount / $originalPrice * 100, 2),
        ];
    }
}
