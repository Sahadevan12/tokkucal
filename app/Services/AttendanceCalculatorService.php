<?php

namespace App\Services;

class AttendanceCalculatorService
{
    /**
     * @return array{
     *     current_percent: float, classes_attended: int, classes_missed: int, total_classes: int,
     *     meets_target: bool, can_miss: int, required_to_attend: int|null, achievable: bool
     * }
     */
    public function calculate(int $totalClasses, int $classesAttended, float $targetPercent): array
    {
        $currentPercent = round($classesAttended / $totalClasses * 100, 2);
        $targetDecimal = $targetPercent / 100;
        $meetsTarget = $currentPercent >= $targetPercent;

        $canMiss = 0;
        $requiredToAttend = 0;
        $achievable = true;

        if ($meetsTarget) {
            $canMiss = (int) floor($classesAttended / $targetDecimal - $totalClasses);
        } elseif ($targetDecimal >= 1) {
            $achievable = false;
            $requiredToAttend = null;
        } else {
            $requiredToAttend = (int) ceil(
                ($targetDecimal * $totalClasses - $classesAttended) / (1 - $targetDecimal)
            );
        }

        return [
            'current_percent' => $currentPercent,
            'classes_attended' => $classesAttended,
            'classes_missed' => $totalClasses - $classesAttended,
            'total_classes' => $totalClasses,
            'meets_target' => $meetsTarget,
            'can_miss' => max(0, $canMiss),
            'required_to_attend' => $requiredToAttend,
            'achievable' => $achievable,
        ];
    }
}
