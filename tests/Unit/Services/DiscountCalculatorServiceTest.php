<?php

namespace Tests\Unit\Services;

use App\Services\DiscountCalculatorService;
use PHPUnit\Framework\TestCase;

class DiscountCalculatorServiceTest extends TestCase
{
    private DiscountCalculatorService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DiscountCalculatorService;
    }

    public function test_discount_from_percent(): void
    {
        $result = $this->service->fromPercent(2000, 25);

        $this->assertSame(500.0, $result['discount_amount']);
        $this->assertSame(1500.0, $result['final_price']);
    }

    public function test_zero_percent_discount_changes_nothing(): void
    {
        $result = $this->service->fromPercent(999, 0);

        $this->assertSame(0.0, $result['discount_amount']);
        $this->assertSame(999.0, $result['final_price']);
    }

    public function test_hundred_percent_discount_makes_item_free(): void
    {
        $result = $this->service->fromPercent(500, 100);

        $this->assertSame(500.0, $result['discount_amount']);
        $this->assertSame(0.0, $result['final_price']);
    }

    public function test_discount_from_sale_price(): void
    {
        $result = $this->service->fromSalePrice(2000, 1500);

        $this->assertSame(500.0, $result['discount_amount']);
        $this->assertSame(25.0, $result['discount_percent']);
    }

    public function test_decimal_prices(): void
    {
        $result = $this->service->fromPercent(999.50, 33.33);

        $this->assertEqualsWithDelta(333.13, $result['discount_amount'], 0.01);
    }

    public function test_sale_price_equal_to_original_gives_zero_discount(): void
    {
        $result = $this->service->fromSalePrice(1000, 1000);

        $this->assertSame(0.0, $result['discount_amount']);
        $this->assertSame(0.0, $result['discount_percent']);
    }
}
