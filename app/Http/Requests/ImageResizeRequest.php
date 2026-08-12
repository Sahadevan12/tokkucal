<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageResizeRequest extends FormRequest
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
        $maintainAspectRatio = filter_var($this->input('maintain_aspect_ratio'), FILTER_VALIDATE_BOOLEAN);

        return [
            'image' => [
                'required',
                'file',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
                'dimensions:max_width=8000,max_height=8000',
            ],
            'width' => [$maintainAspectRatio ? 'required_without:height' : 'required', 'nullable', 'integer', 'min:1', 'max:5000'],
            'height' => [$maintainAspectRatio ? 'required_without:width' : 'required', 'nullable', 'integer', 'min:1', 'max:5000'],
            'maintain_aspect_ratio' => ['nullable', 'boolean'],
            'output_format' => ['required', 'in:jpg,png,webp'],
        ];
    }
}
