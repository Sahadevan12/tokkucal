<?php

namespace Tests\Feature;

use Tests\TestCase;

class CalculatorEndpointsTest extends TestCase
{
    public function test_gst_calculate_returns_correct_totals(): void
    {
        $response = $this->postJson(route('gst-calculator.calculate'), [
            'amount' => 1000,
            'gst_percent' => 18,
            'mode' => 'exclusive',
        ]);

        $response->assertOk()->assertJson([
            'base_amount' => 1000,
            'gst_amount' => 180,
            'total_amount' => 1180,
        ]);
    }

    public function test_gst_calculate_rejects_negative_amount(): void
    {
        $response = $this->postJson(route('gst-calculator.calculate'), [
            'amount' => -100,
            'gst_percent' => 18,
            'mode' => 'exclusive',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['amount']);
    }

    public function test_gst_calculate_rejects_invalid_mode(): void
    {
        $response = $this->postJson(route('gst-calculator.calculate'), [
            'amount' => 1000,
            'gst_percent' => 18,
            'mode' => 'not-a-real-mode',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['mode']);
    }

    public function test_emi_calculate_returns_positive_emi(): void
    {
        $response = $this->postJson(route('emi-calculator.calculate'), [
            'loan_amount' => 500000,
            'annual_rate' => 8.5,
            'tenure_value' => 5,
            'tenure_unit' => 'years',
        ]);

        $response->assertOk();
        $this->assertEqualsWithDelta(10258.28, $response->json('emi'), 1.0);
    }

    public function test_emi_calculate_rejects_zero_tenure(): void
    {
        $response = $this->postJson(route('emi-calculator.calculate'), [
            'loan_amount' => 500000,
            'annual_rate' => 8.5,
            'tenure_value' => 0,
            'tenure_unit' => 'years',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['tenure_value']);
    }

    public function test_percentage_of_mode(): void
    {
        $response = $this->postJson(route('percentage-calculator.calculate'), [
            'mode' => 'of',
            'percent' => 20,
            'of_value' => 250,
        ]);

        $response->assertOk()->assertJson(['result' => 50]);
    }

    public function test_percentage_change_mode_reports_direction(): void
    {
        $response = $this->postJson(route('percentage-calculator.calculate'), [
            'mode' => 'change',
            'old_value' => 200,
            'new_value' => 250,
        ]);

        $response->assertOk()->assertJson(['result' => 25, 'direction' => 'increase']);
    }

    public function test_age_calculate_rejects_future_date_of_birth(): void
    {
        $response = $this->postJson(route('age-calculator.calculate'), [
            'date_of_birth' => now()->addYear()->toDateString(),
            'target_date' => now()->toDateString(),
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['date_of_birth']);
    }

    public function test_age_calculate_returns_breakdown(): void
    {
        $response = $this->postJson(route('age-calculator.calculate'), [
            'date_of_birth' => '2000-01-15',
            'target_date' => '2026-06-10',
        ]);

        $response->assertOk()->assertJson(['years' => 26, 'months' => 4, 'days' => 26]);
    }

    public function test_discount_calculate_from_percent(): void
    {
        $response = $this->postJson(route('discount-calculator.calculate'), [
            'mode' => 'percent',
            'original_price' => 2000,
            'discount_percent' => 25,
        ]);

        $response->assertOk()->assertJson(['discount_amount' => 500, 'final_price' => 1500]);
    }

    public function test_discount_calculate_sale_price_cannot_exceed_original(): void
    {
        $response = $this->postJson(route('discount-calculator.calculate'), [
            'mode' => 'sale-price',
            'original_price' => 1000,
            'sale_price' => 1500,
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['sale_price']);
    }

    public function test_attendance_calculate_above_target(): void
    {
        $response = $this->postJson(route('attendance-calculator.calculate'), [
            'total_classes' => 90,
            'classes_attended' => 80,
            'target_percent' => 75,
        ]);

        $response->assertOk()->assertJson(['meets_target' => true, 'can_miss' => 16]);
    }

    public function test_attendance_calculate_rejects_attended_greater_than_total(): void
    {
        $response = $this->postJson(route('attendance-calculator.calculate'), [
            'total_classes' => 10,
            'classes_attended' => 15,
            'target_percent' => 75,
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['classes_attended']);
    }

    public function test_salary_calculate_returns_take_home(): void
    {
        $response = $this->postJson(route('salary-calculator.calculate'), [
            'annual_ctc' => 1200000,
            'basic' => 500000,
            'hra' => 250000,
            'allowances' => 150000,
            'bonus' => 50000,
            'pf' => 60000,
            'professional_tax' => 2400,
            'other_deductions' => 0,
        ]);

        $response->assertOk()->assertJson(['estimated_take_home' => 887600]);
    }
}
