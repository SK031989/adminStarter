<?php

namespace Modules\ModuleBuilder\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Modules\ModuleBuilder\App\Enums\FieldTypeEnum;

class FieldTypeRule implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validValues = array_column(FieldTypeEnum::cases(), 'value');

        if (!in_array($value, $validValues, true)) {
            $fail("The {$attribute} must be one of: " . implode(', ', $validValues) . '.');
        }
    }
}
