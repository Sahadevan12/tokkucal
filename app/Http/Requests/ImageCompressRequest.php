<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageCompressRequest extends FormRequest
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
            'image' => [
                'required',
                'file',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
                'dimensions:max_width=8000,max_height=8000',
            ],
            'quality' => ['required', 'integer', 'min:10', 'max:100'],
        ];
    }
}
