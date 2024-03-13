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
        return preg_match('/[a-zA-Z]/', $value) && preg_match('/\d/', $value);
    }

    public function message()
    {
        return 'City Name should not be only digits';
    }
}
