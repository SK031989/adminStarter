<?php

namespace Modules\Product\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable',
            'sku' => 'nullable',
            'description' => 'nullable',
            'price' => 'nullable',
            'stock' => 'nullable',
            'category' => 'nullable',
            'image' => 'nullable|image|max:10240',
            'is_featured' => 'nullable',
        ];
    }
}