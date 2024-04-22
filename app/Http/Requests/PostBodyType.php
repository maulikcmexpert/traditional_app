<?php

namespace App\Http\Requests;

use App\Rules\NameValidation;
use Illuminate\Foundation\Http\FormRequest;

class PostBodyType extends FormRequest
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
            'body_type.*' => ['required', 'string', new NameValidation, 'max:255', 'unique:body_types,body_type'],
        ];
    }

    public function messages(): array
    {
        return [
            'body_type.*.required' => 'Please enter a valid Body Type',

            'body_type.*.unique' => 'Body Type already exist',
        ];
    }
}
