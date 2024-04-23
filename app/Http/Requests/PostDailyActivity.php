<?php

namespace App\Http\Requests;

use App\Rules\NameValidation;
use Illuminate\Foundation\Http\FormRequest;

class PostDailyActivity extends FormRequest
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
            'daily_activity.*' => ['required', 'string', new NameValidation, 'max:255', 'unique:daily_activities,daily_activity'],
        ];
    }

    public function messages(): array
    {
        return [
            'daily_activity.*.required' => 'Please enter Daily Activity',

            'daily_activity.*.unique' => 'Daily Activity already exist',
        ];
    }
}
