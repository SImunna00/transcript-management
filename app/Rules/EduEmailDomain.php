<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EduEmailDomain implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!str_ends_with($value, '.edu') && !str_ends_with($value, '.edu.bd')) {
            $fail('The :attribute must be a valid educational email address (.edu domain).');
        }
    }
}
