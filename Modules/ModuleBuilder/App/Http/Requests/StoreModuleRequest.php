<?php

namespace Modules\ModuleBuilder\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreModuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:100', 'unique:dynamic_modules,name'],
            'icon'        => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:500'],
            'status'      => ['required', Rule::in(['active', 'inactive'])],
            'settings'    => ['nullable', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'A module with this name already exists.',
        ];
    }
}
