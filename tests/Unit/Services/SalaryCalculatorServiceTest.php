<?php

namespace Tests\Unit\Services;

use App\Services\SalaryCalculatorService;
use PHPUnit\Framework\TestCase;

class SalaryCalculatorServiceTest extends TestCase
{
    private SalaryCalculatorService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SalaryCalculatorService;
    }

    public function test_take_home_is_gross_minus_deductions(): void
    {
        $result = $this->service->calculate(
            annualCtc: 1200000,
            basic: 500000,
            hra: 250000,
            allowances: 150000,
            bonus: 50000,
            pf: 60000,
            professionalTax: 2400,
            otherDeductions: 0,
        );

        $this->assertSame(950000.0, $result['gross_salary']);
        $this->assertSame(62400.0, $result['estimated_deductions']);
        $this->assertSame(887600.0, $result['estimated_take_home']);
        $this->assertEqualsWithDelta(73966.67, $result['monthly_take_home'], 0.01);
    }

    public function test_zero_deductions(): void
    {
        $result = $this->service->calculate(600000, 300000, 100000, 50000, 0, 0, 0, 0);

        $this->assertSame(450000.0, $result['gross_salary']);
        $this->assertSame(0.0, $result['estimated_deductions']);
        $this->assertSame($result['gross_salary'], $result['estimated_take_home']);
    }

    public function test_monthly_figures_are_annual_divided_by_twelve(): void
    {
        $result = $this->service->calculate(1200000, 600000, 0, 0, 0, 0, 0, 0);

        $this->assertSame(100000.0, $result['monthly_ctc']);
        $this->assertSame(50000.0, $result['monthly_gross']);
    }
}
