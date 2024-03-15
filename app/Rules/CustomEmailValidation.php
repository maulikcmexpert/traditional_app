<?php
// App/Rules/CustomEmailValidation.php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CustomEmailValidation implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if the email starts with a character
        $pattern = '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/';
        if (!preg_match($pattern, $value)) {
            return false;
        }

        // Check if the username part of the email doesn't consist entirely of digits
        // $valueSplit = explode('@', $value);
        // if (ctype_digit($valueSplit[0])) {
        //     return false;
        // }
    }

    public function message()
    {
        return 'Please enter valid Email';
    }
}
