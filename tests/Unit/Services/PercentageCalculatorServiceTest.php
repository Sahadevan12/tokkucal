<?php

namespace Tests\Unit\Services;

use App\Services\PercentageCalculatorService;
use PHPUnit\Framework\TestCase;

class PercentageCalculatorServiceTest extends TestCase
{
    private PercentageCalculatorService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PercentageCalculatorService;
    }

    public function test_percent_of_a_number(): void
    {
        $this->assertSame(50.0, $this->service->percentOf(20, 250));
    }

    public function test_percent_of_zero(): void
    {
        $this->assertSame(0.0, $this->service->percentOf(50, 0));
    }

    public function test_what_percent_one_value_is_of_another(): void
    {
        $this->assertSame(20.0, $this->service->whatPercent(50, 250));
    }

    public function test_percentage_increase(): void
    {
        $this->assertSame(25.0, $this->service->percentageChange(200, 250));
    }

    public function test_percentage_decrease(): void
    {
        $this->assertSame(-25.0, $this->service->percentageChange(200, 150));
    }

    public function test_decimal_values(): void
    {
        $this->assertEqualsWithDelta(33.3333, $this->service->percentOf(33.3333, 100), 0.001);
    }

    public function test_negative_old_value_uses_absolute_denominator(): void
    {
        // (New - Old) / |Old| * 100 — from -100 to -50 is a 50% move toward zero.
        $this->assertSame(50.0, $this->service->percentageChange(-100, -50));
    }
}
