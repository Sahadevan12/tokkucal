<?php

namespace Tests\Unit\Services;

use App\Services\AttendanceCalculatorService;
use PHPUnit\Framework\TestCase;

class AttendanceCalculatorServiceTest extends TestCase
{
    private AttendanceCalculatorService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AttendanceCalculatorService;
    }

    public function test_above_target_reports_how_many_classes_can_be_missed(): void
    {
        $result = $this->service->calculate(90, 80, 75);

        $this->assertTrue($result['meets_target']);
        $this->assertSame(16, $result['can_miss']);
        $this->assertSame(10, $result['classes_missed']);
    }

    public function test_below_target_reports_classes_required_to_attend(): void
    {
        $result = $this->service->calculate(90, 60, 75);

        $this->assertFalse($result['meets_target']);
        $this->assertSame(30, $result['required_to_attend']);
        $this->assertTrue($result['achievable']);
    }

    public function test_meeting_exactly_the_target_percent(): void
    {
        $result = $this->service->calculate(100, 75, 75);

        $this->assertTrue($result['meets_target']);
        $this->assertSame(0, $result['can_miss']);
    }

    public function test_hundred_percent_target_is_unachievable_once_a_class_is_missed(): void
    {
        $result = $this->service->calculate(10, 9, 100);

        $this->assertFalse($result['meets_target']);
        $this->assertFalse($result['achievable']);
        $this->assertNull($result['required_to_attend']);
    }

    public function test_zero_classes_attended(): void
    {
        $result = $this->service->calculate(50, 0, 75);

        $this->assertSame(0.0, $result['current_percent']);
        $this->assertFalse($result['meets_target']);
    }

    public function test_perfect_attendance_meets_any_target(): void
    {
        $result = $this->service->calculate(40, 40, 100);

        $this->assertSame(100.0, $result['current_percent']);
        $this->assertTrue($result['meets_target']);
    }

    public function test_required_to_attend_actually_reaches_target(): void
    {
        $result = $this->service->calculate(90, 60, 75);
        $required = $result['required_to_attend'];

        $projectedPercent = (60 + $required) / (90 + $required) * 100;

        $this->assertGreaterThanOrEqual(75.0, $projectedPercent);
    }
}
