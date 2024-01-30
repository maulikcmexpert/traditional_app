<?php


namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;

class CustomUserProvider extends EloquentUserProvider
{
    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials($user, array $credentials)
    {
        // Customize the validation logic here
        return true; // Always return true to skip password validation
    }
}


?>