<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MobileNumberValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }
    public function passes($attribute, $value)
    {
        // Check if the value is a string and exactly 13 characters long
        if (is_string($value) && strlen($value) >= 7 && strlen($value) <= 15) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if (strlen($value) < 7) {
            return 'Minimum length is 7 digits';
        } elseif (strlen($value) > 15) {
            return 'Maximum length is 15 digits';
        } else {
            return 'The :attribute is invalid.';
        }
    }
}
