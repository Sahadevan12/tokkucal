<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesTool;
use App\Http\Requests\AgeCalculatorRequest;
use App\Http\Requests\AttendanceCalculatorRequest;
use App\Http\Requests\DiscountCalculatorRequest;
use App\Http\Requests\EmiCalculatorRequest;
use App\Http\Requests\GstCalculatorRequest;
use App\Http\Requests\PercentageCalculatorRequest;
use App\Http\Requests\SalaryCalculatorRequest;
use App\Services\AgeCalculatorService;
use App\Services\AttendanceCalculatorService;
use App\Services\DiscountCalculatorService;
use App\Services\EmiCalculatorService;
use App\Services\GstCalculatorService;
use App\Services\PercentageCalculatorService;
use App\Services\SalaryCalculatorService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CalculatorController extends Controller
{
    use ResolvesTool;

    public function gst(): View
    {
        $tool = $this->tool('gst-calculator');

        return view('tools.gst-calculator', [
            ...$this->seoFor($tool),
            'tool' => $tool,
            'jsonLd' => $this->jsonLdFor($tool),
            'breadcrumbs' => $this->breadcrumbsFor($tool),
        ]);
    }

    public function gstCalculate(GstCalculatorRequest $request, GstCalculatorService $service): JsonResponse
    {
        $data = $request->validated();

        return response()->json(
            $service->calculate((float) $data['amount'], (float) $data['gst_percent'], $data['mode'])
        );
    }

    public function emi(): View
    {
        $tool = $this->tool('emi-calculator');

        return view('tools.emi-calculator', [
            ...$this->seoFor($tool),
            'tool' => $tool,
            'jsonLd' => $this->jsonLdFor($tool),
            'breadcrumbs' => $this->breadcrumbsFor($tool),
        ]);
    }

    public function emiCalculate(EmiCalculatorRequest $request, EmiCalculatorService $service): JsonResponse
    {
        $data = $request->validated();

        return response()->json(
            $service->calculate((float) $data['loan_amount'], (float) $data['annual_rate'], $request->tenureInMonths())
        );
    }

    public function percentage(): View
    {
        $tool = $this->tool('percentage-calculator');

        return view('tools.percentage-calculator', [
            ...$this->seoFor($tool),
            'tool' => $tool,
            'jsonLd' => $this->jsonLdFor($tool),
            'breadcrumbs' => $this->breadcrumbsFor($tool),
        ]);
    }

    public function percentageCalculate(PercentageCalculatorRequest $request, PercentageCalculatorService $service): JsonResponse
    {
        $data = $request->validated();

        $result = match ($data['mode']) {
            'of' => [
                'result' => $service->percentOf((float) $data['percent'], (float) $data['of_value']),
            ],
            'is-percent' => [
                'result' => $service->whatPercent((float) $data['value'], (float) $data['of_value']),
            ],
            'change' => (function () use ($service, $data) {
                $change = $service->percentageChange((float) $data['old_value'], (float) $data['new_value']);

                return [
                    'result' => abs($change),
                    'direction' => $change >= 0 ? 'increase' : 'decrease',
                    'signed_result' => $change,
                ];
            })(),
        };

        return response()->json(['mode' => $data['mode'], ...$result]);
    }

    public function age(): View
    {
        $tool = $this->tool('age-calculator');

        return view('tools.age-calculator', [
            ...$this->seoFor($tool),
            'tool' => $tool,
            'jsonLd' => $this->jsonLdFor($tool),
            'breadcrumbs' => $this->breadcrumbsFor($tool),
        ]);
    }

    public function ageCalculate(AgeCalculatorRequest $request, AgeCalculatorService $service): JsonResponse
    {
        $data = $request->validated();
        $target = $data['target_date'] ?? null;

        return response()->json($service->calculate(
            Carbon::parse($data['date_of_birth']),
            $target ? Carbon::parse($target) : Carbon::today()
        ));
    }

    public function salary(): View
    {
        $tool = $this->tool('salary-calculator');

        return view('tools.salary-calculator', [
            ...$this->seoFor($tool),
            'tool' => $tool,
            'jsonLd' => $this->jsonLdFor($tool),
            'breadcrumbs' => $this->breadcrumbsFor($tool),
        ]);
    }

    public function salaryCalculate(SalaryCalculatorRequest $request, SalaryCalculatorService $service): JsonResponse
    {
        $data = $request->validated();

        return response()->json($service->calculate(
            (float) $data['annual_ctc'],
            (float) $data['basic'],
            (float) $data['hra'],
            (float) $data['allowances'],
            (float) $data['bonus'],
            (float) $data['pf'],
            (float) $data['professional_tax'],
            (float) $data['other_deductions'],
        ));
    }

    public function discount(): View
    {
        $tool = $this->tool('discount-calculator');

        return view('tools.discount-calculator', [
            ...$this->seoFor($tool),
            'tool' => $tool,
            'jsonLd' => $this->jsonLdFor($tool),
            'breadcrumbs' => $this->breadcrumbsFor($tool),
        ]);
    }

    public function discountCalculate(DiscountCalculatorRequest $request, DiscountCalculatorService $service): JsonResponse
    {
        $data = $request->validated();

        $result = $data['mode'] === 'sale-price'
            ? $service->fromSalePrice((float) $data['original_price'], (float) $data['sale_price'])
            : $service->fromPercent((float) $data['original_price'], (float) $data['discount_percent']);

        return response()->json(['mode' => $data['mode'], ...$result]);
    }

    public function attendance(): View
    {
        $tool = $this->tool('attendance-calculator');

        return view('tools.attendance-calculator', [
            ...$this->seoFor($tool),
            'tool' => $tool,
            'jsonLd' => $this->jsonLdFor($tool),
            'breadcrumbs' => $this->breadcrumbsFor($tool),
        ]);
    }

    public function attendanceCalculate(AttendanceCalculatorRequest $request, AttendanceCalculatorService $service): JsonResponse
    {
        $data = $request->validated();

        return response()->json($service->calculate(
            (int) $data['total_classes'],
            (int) $data['classes_attended'],
            (float) $data['target_percent'],
        ));
    }
}
