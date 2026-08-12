<?php

namespace App\Services;

class GstCalculatorService
{
    /**
     * @return array{mode: string, gst_percent: float, base_amount: float, gst_amount: float, total_amount: float}
     */
    public function calculate(float $amount, float $gstPercent, string $mode): array
    {
        if ($mode === 'inclusive') {
            $baseAmount = round($amount * 100 / (100 + $gstPercent), 2);
            $gstAmount = round($amount - $baseAmount, 2);
            $totalAmount = round($amount, 2);
        } else {
            $baseAmount = round($amount, 2);
            $gstAmount = round($amount * $gstPercent / 100, 2);
            $totalAmount = round($baseAmount + $gstAmount, 2);
        }

        return [
            'mode' => $mode,
            'gst_percent' => $gstPercent,
            'base_amount' => $baseAmount,
            'gst_amount' => $gstAmount,
            'total_amount' => $totalAmount,
        ];
    }
}
