<?php

namespace Modules\Auth\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Auth\App\Rules\StrongPasswordRule;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', new StrongPasswordRule()],
            'phone'    => ['nullable', 'string', 'max:20'],
        ];

        if (config('auth-module.tenant.auto_create', false)) {
            $rules['company_name'] = ['required', 'string', 'max:255'];
        }

        return $rules;
    }
}
