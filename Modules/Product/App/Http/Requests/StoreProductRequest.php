<?php

namespace Modules\Product\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'sku' => 'required',
            'description' => 'nullable',
            'price' => 'required',
            'stock' => 'nullable',
            'category' => 'nullable',
            'image' => 'nullable|image|max:10240',
            'is_featured' => 'nullable',
        ];
    }
}