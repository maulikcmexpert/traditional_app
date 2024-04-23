<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NameValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $attribute = ucfirst($attribute);
        if ($attribute == 'interest_and_hobby.0') {
            $attribute = "Interest and Hobby";
        }
        if ($attribute == 'size_of_organization.0') {
            $attribute = "Size of Organization";
        }

        $charCount = 0;
        foreach (str_split($value) as $char) {
            if (ctype_alpha($char)) { // Check if the character is a letter
                $charCount++;
            }
        }
        if ($charCount < 2) {
            $fail("Please enter valid " . str_replace('_', " ", $attribute));
        }
        if (ctype_digit(trim($value))) {
            $fail("Please enter valid " . str_replace('_', " ", $attribute));
        }

        if (preg_match('/^[^a-zA-Z0-9 ]+$/', trim($value))) {
            $fail("Please enter valid " . str_replace('_', " ", $attribute));
        }

        if (preg_match('/^[0-9@#$%^&*()_+=\[\]{};:,.<>?|\\/-]+$/', $value)) {
            $fail("Please enter valid " . str_replace('_', " ", $attribute));
        }
    }
}
