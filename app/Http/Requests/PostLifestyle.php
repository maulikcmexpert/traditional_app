<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NameValidation;

class PostLifestyle extends FormRequest
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
            'lifestyle.*' => ['required', new NameValidation, 'max:255', 'unique:lifestyles,life_style'],
        ];
    }

    public function messages(): array
    {
        return [
            'lifestyle.*.required' => 'Please enter Lifestyle',

            'lifestyle.*.unique' => 'Lifestyle already exist',
        ];
    }
}
