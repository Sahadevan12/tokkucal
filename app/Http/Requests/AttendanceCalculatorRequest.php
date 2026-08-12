<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceCalculatorRequest extends FormRequest
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
            'total_classes' => ['required', 'integer', 'min:1', 'max:10000'],
            'classes_attended' => ['required', 'integer', 'min:0', 'lte:total_classes'],
            'target_percent' => ['required', 'numeric', 'min:1', 'max:100'],
        ];
    }
}
