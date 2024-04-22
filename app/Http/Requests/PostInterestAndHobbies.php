<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NameValidation;

class PostInterestAndHobbies extends FormRequest
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
            'interest_and_hobby.*' => ['required', new NameValidation, 'max:255', 'unique:interest_and_hobbies,interest_and_hobby'],
        ];
    }
    public function messages(): array
    {
        return [
            'interest_and_hobby.*.required' => 'Please enter a valid Interest and Hobby.',

            'interest_and_hobby.*.unique' => 'Interest and Hobby already exist',
        ];
    }
}
