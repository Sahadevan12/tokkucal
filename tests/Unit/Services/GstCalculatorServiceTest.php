<?php

namespace Tests\Unit\Services;

use App\Services\GstCalculatorService;
use PHPUnit\Framework\TestCase;

class GstCalculatorServiceTest extends TestCase
{
    private GstCalculatorService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new GstCalculatorService;
    }

    public function test_exclusive_gst_at_eighteen_percent(): void
    {
        $result = $this->service->calculate(1000, 18, 'exclusive');

        $this->assertSame(1000.0, $result['base_amount']);
        $this->assertSame(180.0, $result['gst_amount']);
        $this->assertSame(1180.0, $result['total_amount']);
    }

    public function test_inclusive_gst_at_eighteen_percent(): void
    {
        $result = $this->service->calculate(1180, 18, 'inclusive');

        $this->assertSame(1000.0, $result['base_amount']);
        $this->assertSame(180.0, $result['gst_amount']);
        $this->assertSame(1180.0, $result['total_amount']);
    }

    public function test_zero_percent_gst_slab(): void
    {
        $result = $this->service->calculate(500, 0, 'exclusive');

        $this->assertSame(0.0, $result['gst_amount']);
        $this->assertSame(500.0, $result['total_amount']);
    }

    public function test_decimal_amount_and_rate(): void
    {
        $result = $this->service->calculate(999.99, 12.5, 'exclusive');

        $this->assertSame(125.0, $result['gst_amount']);
        $this->assertSame(1124.99, $result['total_amount']);
    }

    public function test_twenty_eight_percent_slab_inclusive(): void
    {
        $result = $this->service->calculate(1280, 28, 'inclusive');

        $this->assertSame(1000.0, $result['base_amount']);
        $this->assertSame(280.0, $result['gst_amount']);
    }
}
