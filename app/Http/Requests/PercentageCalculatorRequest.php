<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PercentageCalculatorRequest extends FormRequest
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
        $ofValueRules = ['required_if:mode,of,is-percent', 'numeric'];
        if ($this->input('mode') === 'is-percent') {
            $ofValueRules[] = 'not_in:0';
        }

        return [
            'mode' => ['required', 'in:of,is-percent,change'],
            'percent' => ['required_if:mode,of', 'numeric'],
            'of_value' => $ofValueRules,
            'value' => ['required_if:mode,is-percent', 'numeric'],
            'old_value' => ['required_if:mode,change', 'numeric', 'not_in:0'],
            'new_value' => ['required_if:mode,change', 'numeric'],
        ];
    }
}
