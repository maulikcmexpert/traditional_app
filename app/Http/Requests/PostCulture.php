<?php

namespace App\Http\Requests;

use App\Rules\NameValidation;
use Illuminate\Foundation\Http\FormRequest;

class PostCulture extends FormRequest
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
            'culture.*' => ['required', 'string', new NameValidation, 'max:255', 'unique:cultures,culture'],
        ];
    }

    public function messages(): array
    {
        return [
            'culture.*.required' => 'Please enter a valid Faith',

            'culture.*.unique' => 'Faith already exist',
        ];
    }
}
