<?php

namespace App\Services;

class PercentageCalculatorService
{
    public function percentOf(float $percent, float $of): float
    {
        return round($percent * $of / 100, 4);
    }

    public function whatPercent(float $value, float $of): float
    {
        return round($value / $of * 100, 4);
    }

    public function percentageChange(float $old, float $new): float
    {
        return round(($new - $old) / abs($old) * 100, 4);
    }
}
