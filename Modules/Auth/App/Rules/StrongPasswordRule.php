<?php

namespace Modules\Auth\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StrongPasswordRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $minLength = config('auth-module.password.min_length', 8);

        if (strlen($value) < $minLength) {
            $fail("The {$attribute} must be at least {$minLength} characters.");
            return;
        }

        if (config('auth-module.password.require_uppercase', true) && !preg_match('/[A-Z]/', $value)) {
            $fail("The {$attribute} must contain at least one uppercase letter.");
            return;
        }

        if (config('auth-module.password.require_number', true) && !preg_match('/[0-9]/', $value)) {
            $fail("The {$attribute} must contain at least one number.");
            return;
        }

        if (config('auth-module.password.require_symbol', false) && !preg_match('/[\W_]/', $value)) {
            $fail("The {$attribute} must contain at least one special character.");
        }
    }
}
