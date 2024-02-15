<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'interest_and_hobby.*' => ['required', 'string', 'max:255', 'unique:interest_and_hobbies,interest_and_hobby'],
        ];
    }
}
