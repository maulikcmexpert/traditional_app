<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OrganizationNameValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (ctype_digit(trim($value))) {
            $fail("Church/Organization Name should not be only digits");
        }

        if (preg_match("/^[^a-zA-Z0-9 ]+$/", trim($value))) {
            $fail("Church/Organization Name should not be special characters");
        }

        if (preg_match("/^[0-9@#$%^&*()_+=\[\]{};:,.<>?|\\/-]+$/", $value)) {
            $fail(":Please enter valid Organization Name");
        }
    }
}
