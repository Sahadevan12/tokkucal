<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmiCalculatorRequest extends FormRequest
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
        $maxTenure = $this->input('tenure_unit') === 'years' ? 40 : 480;

        return [
            'loan_amount' => ['required', 'numeric', 'min:1', 'max:999999999'],
            'annual_rate' => ['required', 'numeric', 'min:0', 'max:50'],
            'tenure_value' => ['required', 'numeric', 'min:1', 'max:'.$maxTenure],
            'tenure_unit' => ['required', 'in:months,years'],
        ];
    }

    public function tenureInMonths(): int
    {
        $value = (float) $this->validated('tenure_value');

        return (int) round($this->validated('tenure_unit') === 'years' ? $value * 12 : $value);
    }
}
