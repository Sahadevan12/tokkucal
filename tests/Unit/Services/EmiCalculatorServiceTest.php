<?php

namespace Tests\Unit\Services;

use App\Services\EmiCalculatorService;
use PHPUnit\Framework\TestCase;

class EmiCalculatorServiceTest extends TestCase
{
    private EmiCalculatorService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new EmiCalculatorService;
    }

    public function test_standard_loan_emi(): void
    {
        $result = $this->service->calculate(500000, 8.5, 60);

        $this->assertEqualsWithDelta(10258.28, $result['emi'], 1.0);
        $this->assertSame(60, $result['months']);
        $this->assertGreaterThan(0, $result['total_interest']);
        $this->assertEqualsWithDelta($result['emi'] * 60, $result['total_payment'], 0.5);
    }

    public function test_zero_interest_rate_divides_evenly(): void
    {
        $result = $this->service->calculate(120000, 0, 12);

        $this->assertSame(10000.0, $result['emi']);
        $this->assertSame(0.0, $result['total_interest']);
        $this->assertSame(120000.0, $result['total_payment']);
    }

    public function test_single_month_tenure(): void
    {
        $result = $this->service->calculate(10000, 12, 1);

        $this->assertEqualsWithDelta(10100.0, $result['emi'], 1.0);
    }

    public function test_yearly_breakdown_covers_full_tenure(): void
    {
        $result = $this->service->calculate(500000, 8.5, 24);

        $this->assertCount(2, $result['yearly_breakdown']);
        $this->assertEquals(0.0, $result['yearly_breakdown'][1]['balance']);
    }

    public function test_total_payment_equals_principal_plus_interest(): void
    {
        $result = $this->service->calculate(250000, 10, 36);

        $this->assertEqualsWithDelta(
            250000 + $result['total_interest'],
            $result['total_payment'],
            0.5
        );
    }
}
