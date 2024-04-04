<?php

namespace App\Http\Requests;

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
            'object_type' => ['required', 'string', 'max:255', 'unique:verification_objects,object_type'],
            'object_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:1048',
        ];
    }
}
