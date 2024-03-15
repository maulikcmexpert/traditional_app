<?php
// App/Rules/CustomEmailValidation.php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CustomEmailValidation implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if the email starts with a character
        return preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $value);
    }

    public function message()
    {
        return 'Please enter valid Email';
    }
}
