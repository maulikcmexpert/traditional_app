<?php
// App/Rules/CustomEmailValidation.php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CustomEmailValidation implements Rule
{
    public function passes($attribute, $value)
    {
        $email = explode('@', $value)[0];

        // Check if the email contains only digits
        return ctype_digit($email);
    }

    public function message()
    {
        return 'Please enter valid Email';
    }
}
