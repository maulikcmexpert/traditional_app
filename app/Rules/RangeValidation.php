<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RangeValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        // Check if value matches the specified pattern
        if (!preg_match('/^\d{2}-\d{2}$/', $value)) {
            $fail("The $attribute must be in the format 0-50, where is a digit.");
            return;
        }
    }
}
