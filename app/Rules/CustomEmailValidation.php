<?php
// App/Rules/CustomEmailValidation.php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CustomEmailValidation implements Rule
{
    public function passes($attribute, $value)
    {
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $value)) {
            return false;
        } elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z]+[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $value)) {
            return false;
        } elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}[a-zA-Z0-9]*$/', $value)) {
            return false;
        }
    }

    public function message()
    {
        return 'Please enter valid Email';
    }
}
