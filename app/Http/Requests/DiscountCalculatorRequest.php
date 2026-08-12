<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountCalculatorRequest extends FormRequest
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
            'mode' => ['required', 'in:percent,sale-price'],
            'original_price' => ['required', 'numeric', 'min:0.01', 'max:999999999'],
            'discount_percent' => ['required_if:mode,percent', 'numeric', 'min:0', 'max:100'],
            'sale_price' => ['required_if:mode,sale-price', 'numeric', 'min:0', 'lte:original_price'],
        ];
    }
}
