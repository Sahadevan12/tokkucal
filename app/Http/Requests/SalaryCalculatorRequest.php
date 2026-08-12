<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalaryCalculatorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'annual_ctc' => ['required', 'numeric', 'min:0', 'max:999999999'],
            'basic' => ['required', 'numeric', 'min:0', 'max:999999999'],
            'hra' => ['required', 'numeric', 'min:0', 'max:999999999'],
            'allowances' => ['required', 'numeric', 'min:0', 'max:999999999'],
            'bonus' => ['required', 'numeric', 'min:0', 'max:999999999'],
            'pf' => ['required', 'numeric', 'min:0', 'max:999999999'],
            'professional_tax' => ['required', 'numeric', 'min:0', 'max:999999999'],
            'other_deductions' => ['required', 'numeric', 'min:0', 'max:999999999'],
        ];
    }
}
