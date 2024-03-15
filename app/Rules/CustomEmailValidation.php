<?php
// App/Rules/CustomEmailValidation.php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CustomEmailValidation implements Rule
{
    public function passes($attribute, $value)
    {
        if (preg_match('/^\d+$/', $value)) {
            return false;
        }

        // Check if the email contains '@', 'gmail', or '.com'
        if (preg_match('/@|gmail|.com/', $value)) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'Please enter valid Email';
    }
}
