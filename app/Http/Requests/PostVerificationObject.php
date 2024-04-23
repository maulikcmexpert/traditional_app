<?php

namespace App\Http\Requests;

use App\Rules\NameValidation;
use Illuminate\Foundation\Http\FormRequest;

class PostVerificationObject extends FormRequest
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
            'object_type' => ['required', 'string', 'max:255', new NameValidation, 'unique:verification_objects,object_type'],
            'object_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:1048',
        ];
    }

    public function messages(): array
    {
        return [
            'object_type.*.required' => 'Please enter Object Type',

            'object_type.*.unique' => 'Object Type already exist',
        ];
    }
}
