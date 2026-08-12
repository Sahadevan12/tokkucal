<?php

namespace Tests\Unit\Services;

use App\Services\AgeCalculatorService;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class AgeCalculatorServiceTest extends TestCase
{
    private AgeCalculatorService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AgeCalculatorService;
    }

    public function test_exact_years_for_a_birthday_that_already_happened_this_year(): void
    {
        $result = $this->service->calculate(Carbon::parse('2000-01-15'), Carbon::parse('2026-06-10'));

        $this->assertSame(26, $result['years']);
        $this->assertSame(4, $result['months']);
        $this->assertSame(26, $result['days']);
    }

    public function test_same_day_gives_zero_age(): void
    {
        $result = $this->service->calculate(Carbon::parse('2026-06-10'), Carbon::parse('2026-06-10'));

        $this->assertSame(0, $result['years']);
        $this->assertSame(0, $result['months']);
        $this->assertSame(0, $result['days']);
        $this->assertSame(0, $result['days_to_next_birthday']);
    }

    public function test_leap_year_is_not_approximated_with_365_days(): void
    {
        // 2000-02-29 to 2004-02-29 is exactly 4 years (spans one extra leap day
        // beyond 4*365, so a naive days/365 estimate would be wrong here).
        $result = $this->service->calculate(Carbon::parse('2000-02-29'), Carbon::parse('2004-02-29'));

        $this->assertSame(4, $result['years']);
        $this->assertSame(0, $result['months']);
        $this->assertSame(0, $result['days']);
        $this->assertSame(1461, $result['total_days']);
    }

    public function test_total_months_and_weeks_are_consistent(): void
    {
        $result = $this->service->calculate(Carbon::parse('2020-01-01'), Carbon::parse('2022-01-01'));

        $this->assertSame(24, $result['total_months']);
        $this->assertSame(731, $result['total_days']);
        $this->assertSame(104, $result['total_weeks']);
    }

    public function test_next_birthday_rolls_over_to_next_year(): void
    {
        $result = $this->service->calculate(Carbon::parse('2000-03-01'), Carbon::parse('2026-06-10'));

        $this->assertSame('2027-03-01', $result['next_birthday_date']);
    }

    public function test_next_birthday_later_this_year(): void
    {
        $result = $this->service->calculate(Carbon::parse('2000-12-25'), Carbon::parse('2026-06-10'));

        $this->assertSame('2026-12-25', $result['next_birthday_date']);
    }
}
