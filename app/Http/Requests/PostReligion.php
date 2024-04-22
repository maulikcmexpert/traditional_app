<?php

namespace App\Http\Requests;

use App\Rules\NameValidation;
use Illuminate\Foundation\Http\FormRequest;

class PostReligion extends FormRequest
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
            'religion.*' => ['required', 'string', 'max:255', new NameValidation, 'unique:religions,religion'],
        ];
    }

    public function messages(): array
    {
        return [
            'religion.*.required' => 'Please enter Religion',

            'religion.*.unique' => 'Religion already exist',
        ];
    }
}
