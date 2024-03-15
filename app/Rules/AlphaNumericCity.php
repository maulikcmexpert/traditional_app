<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;

class AlphaNumericCity implements Rule
{
    protected $message;
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function passes($attribute, $value)
    {
        // Check if the value contains at least one letter and one digit
        if (ctype_digit(trim($value))) {
            $this->message = "City Name should not be only digits";
            return false;
        }

        if (preg_match("/^[^a-zA-Z0-9 ]+$/", trim($value))) {
            $this->message = "City Name cannot contain special characters";
            return false;
        }

        if (preg_match("/^[0-9@#$%^&*()_+=\[\]{};:,.<>?|\\/-]+$/", $value)) {
            $this->message = "City Name should not be only numbers and special characters";
            return false;
        }
    }
    public function message()
    {
        return $this->message;
    }
}
