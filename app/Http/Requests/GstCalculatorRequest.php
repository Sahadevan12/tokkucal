<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GstCalculatorRequest extends FormRequest
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
            'amount' => ['required', 'numeric', 'min:0.01', 'max:999999999'],
            'gst_percent' => ['required', 'numeric', 'min:0', 'max:100'],
            'mode' => ['required', 'in:exclusive,inclusive'],
        ];
    }
}
