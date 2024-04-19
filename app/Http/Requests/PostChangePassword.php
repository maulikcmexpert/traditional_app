<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PostChangePassword extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'min:8', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
            'new_password' => ['required', 'string', 'min:8', 'different:current_password'],
            'confirm_password' => ['required', 'min:8', 'same:new_password'],

        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Please enter Current Password',
            'current_password.min' => 'Current Password must be at least 8 characters',
            'new_password.required' => 'Please enter New Password',
            'new_password.min' => 'Password must be at least 8 characters',
            'new_password.different' => 'New Password must be different from old Password',

            'confirm_password.required' => 'Please enter Confirm Password',
            'confirm_password.min' => 'Confirm Password must be at least 8 characters',
            'confirm_password.same' => 'Confirm Password does not match with New Password',
        ];
    }
}
