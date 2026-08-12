<?php

namespace App\Services;

class EmiCalculatorService
{
    /**
     * @return array{
     *     emi: float, total_payment: float, total_interest: float, months: int,
     *     yearly_breakdown: array<int, array{year: int, principal_paid: float, interest_paid: float, balance: float}>
     * }
     */
    public function calculate(float $principal, float $annualRate, int $months): array
    {
        $monthlyRate = $annualRate / 12 / 100;

        if ($monthlyRate == 0.0) {
            $emi = $principal / $months;
        } else {
            $factor = (1 + $monthlyRate) ** $months;
            $emi = $principal * $monthlyRate * $factor / ($factor - 1);
        }

        $emi = round($emi, 2);
        $totalPayment = round($emi * $months, 2);
        $totalInterest = round($totalPayment - $principal, 2);

        return [
            'emi' => $emi,
            'total_payment' => $totalPayment,
            'total_interest' => $totalInterest,
            'months' => $months,
            'yearly_breakdown' => $this->yearlyBreakdown($principal, $monthlyRate, $emi, $months),
        ];
    }

    /**
     * @return array<int, array{year: int, principal_paid: float, interest_paid: float, balance: float}>
     */
    private function yearlyBreakdown(float $principal, float $monthlyRate, float $emi, int $months): array
    {
        $balance = $principal;
        $year = 1;
        $yearlyPrincipal = 0.0;
        $yearlyInterest = 0.0;
        $breakdown = [];

        for ($month = 1; $month <= $months; $month++) {
            $interestPortion = $balance * $monthlyRate;
            $principalPortion = $emi - $interestPortion;
            $balance = max(0, $balance - $principalPortion);

            $yearlyPrincipal += $principalPortion;
            $yearlyInterest += $interestPortion;

            if ($month % 12 === 0 || $month === $months) {
                $breakdown[] = [
                    'year' => $year,
                    'principal_paid' => round($yearlyPrincipal, 2),
                    'interest_paid' => round($yearlyInterest, 2),
                    'balance' => round($balance, 2),
                ];
                $year++;
                $yearlyPrincipal = 0.0;
                $yearlyInterest = 0.0;
            }
        }

        return $breakdown;
    }
}
