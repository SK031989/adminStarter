<?php

namespace Modules\ModuleBuilder\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\ModuleBuilder\App\Enums\FieldTypeEnum;
use Modules\ModuleBuilder\App\Rules\FieldTypeRule;

class StoreFieldRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'field_name'       => [
                'required',
                'string',
                'max:64',
                'regex:/^[a-z][a-z0-9_]*$/',
                Rule::unique('dynamic_fields', 'field_name')
                    ->where('module_id', $this->route('moduleBuilder')?->id),
            ],
            'label'            => ['required', 'string', 'max:100'],
            'type'             => ['required', new FieldTypeRule],
            'is_required'      => ['boolean'],
            'is_searchable'    => ['boolean'],
            'is_filterable'    => ['boolean'],
            'is_sortable'      => ['boolean'],
            'is_nullable'      => ['boolean'],
            'default_value'    => ['nullable', 'string', 'max:255'],
            'options'          => ['nullable', 'array'],
            'options.*'        => ['string', 'max:100'],
            'validation_rules' => ['nullable', 'string', 'max:500'],
            'placeholder'      => ['nullable', 'string', 'max:255'],
            'help_text'        => ['nullable', 'string', 'max:500'],
            'status'           => ['nullable', Rule::in(['active', 'inactive'])],
        ];
    }

    public function messages(): array
    {
        return [
            'field_name.regex'  => 'Field name must start with a letter and contain only lowercase letters, numbers, and underscores.',
            'field_name.unique' => 'This field name already exists in this module.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_required'   => $this->boolean('is_required'),
            'is_searchable' => $this->boolean('is_searchable'),
            'is_filterable' => $this->boolean('is_filterable'),
            'is_sortable'   => $this->boolean('is_sortable'),
            'is_nullable'   => $this->boolean('is_nullable'),
            'status'        => $this->input('status', 'active'),
        ]);
    }
}
