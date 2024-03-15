<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;

class AlphaNumericCity implements Rule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function passes($attribute, $value)
    {
        // Check if the value contains at least one letter and one digit
        if (ctype_digit(trim($value))) {
            $fail("City Name should not be only digits");
        }

        if (preg_match("/^[^a-zA-Z0-9 ]+$/", trim($value))) {
            $fail("City Name cannot contain special characters");
        }

        if (preg_match("/^[0-9@#$%^&*()_+=\[\]{};:,.<>?|\\/-]+$/", $value)) {
            $fail(":City Name must not contain only numbers and special characters.");
        }
    }
}
