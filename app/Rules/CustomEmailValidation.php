<?php
// App/Rules/CustomEmailValidation.php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CustomEmailValidation implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if the email starts with a character
        return preg_match('/^[A-Za-z]/', $value) === 1;
    }

    public function message()
    {
        return 'Please enter Email must be start with character';
    }
}
