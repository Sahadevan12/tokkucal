<?php

namespace App\Services;

class SalaryCalculatorService
{
    /**
     * @return array{
     *     annual_ctc: float, monthly_ctc: float,
     *     gross_salary: float, monthly_gross: float,
     *     estimated_deductions: float, monthly_deductions: float,
     *     estimated_take_home: float, monthly_take_home: float
     * }
     */
    public function calculate(
        float $annualCtc,
        float $basic,
        float $hra,
        float $allowances,
        float $bonus,
        float $pf,
        float $professionalTax,
        float $otherDeductions,
    ): array {
        $grossSalary = round($basic + $hra + $allowances + $bonus, 2);
        $estimatedDeductions = round($pf + $professionalTax + $otherDeductions, 2);
        $takeHome = round($grossSalary - $estimatedDeductions, 2);

        return [
            'annual_ctc' => round($annualCtc, 2),
            'monthly_ctc' => round($annualCtc / 12, 2),
            'gross_salary' => $grossSalary,
            'monthly_gross' => round($grossSalary / 12, 2),
            'estimated_deductions' => $estimatedDeductions,
            'monthly_deductions' => round($estimatedDeductions / 12, 2),
            'estimated_take_home' => $takeHome,
            'monthly_take_home' => round($takeHome / 12, 2),
        ];
    }
}
