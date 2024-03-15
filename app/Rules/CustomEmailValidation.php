<?php
// App/Rules/CustomEmailValidation.php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CustomEmailValidation implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if the email starts with a character
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // Check if the username part of the email doesn't consist entirely of digits
        $valueSplit = explode('@', $value);
        if (ctype_digit($valueSplit[0])) {
            return false;
        }
    }

    public function message()
    {
        return 'Please enter valid Email';
    }
}
