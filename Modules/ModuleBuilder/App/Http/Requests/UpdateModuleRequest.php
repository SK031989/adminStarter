<?php

namespace Modules\ModuleBuilder\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateModuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $moduleId = $this->route('moduleBuilder')?->id;

        return [
            'name'        => ['required', 'string', 'max:100', Rule::unique('dynamic_modules', 'name')->ignore($moduleId)],
            'icon'        => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:500'],
            'status'      => ['required', Rule::in(['active', 'inactive'])],
            'settings'    => ['nullable', 'array'],
        ];
    }
}
