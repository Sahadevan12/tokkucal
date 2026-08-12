<?php

namespace App\Services;

use Carbon\Carbon;

class AgeCalculatorService
{
    /**
     * @return array{
     *     years: int, months: int, days: int,
     *     total_days: int, total_weeks: int, total_months: int,
     *     next_birthday_date: string, days_to_next_birthday: int
     * }
     */
    public function calculate(Carbon $dateOfBirth, Carbon $targetDate): array
    {
        $dob = $dateOfBirth->copy()->startOfDay();
        $target = $targetDate->copy()->startOfDay();

        $diff = $dob->diff($target);

        $nextBirthday = $dob->copy()->year($target->year);
        if ($nextBirthday->lessThan($target)) {
            $nextBirthday = $nextBirthday->addYear();
        }

        return [
            'years' => $diff->y,
            'months' => $diff->m,
            'days' => $diff->d,
            'total_days' => (int) $dob->diffInDays($target),
            'total_weeks' => (int) floor($dob->diffInDays($target) / 7),
            'total_months' => ($diff->y * 12) + $diff->m,
            'next_birthday_date' => $nextBirthday->toDateString(),
            'days_to_next_birthday' => (int) $target->diffInDays($nextBirthday),
        ];
    }
}
