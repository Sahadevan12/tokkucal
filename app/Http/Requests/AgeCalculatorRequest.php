<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgeCalculatorRequest extends FormRequest
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
            'date_of_birth' => ['required', 'date', 'before_or_equal:target_date', 'after:1900-01-01'],
            'target_date' => ['nullable', 'date'],
        ];
    }
}
