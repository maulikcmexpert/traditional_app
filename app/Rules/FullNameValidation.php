<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FullNameValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (ctype_digit(trim($value))) {
            $fail("Full Name should not be only digits");
        }

        if (preg_match("/^[^a-zA-Z0-9 ]+$/", trim($value))) {
            $fail("Full Name cannot contain special characters");
        }

        if (preg_match("/^[0-9@#$%^&*()_+=\[\]{};:,.<>?|\\/-]+$/", $value)) {
            $fail(":Full Name must not contain only numbers and special characters.");
        }
    }
}
