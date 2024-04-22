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
        $attribute =   (str_replace('_', " ", $attribute));
        if (!preg_match('/^(\d+\.?\d*) ?- ?(\d+\.?\d*)$/', $value)) {
            $fail("Please enter valid $attribute");
            return;
        }
    }
}
