<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCurseWord extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'words.*' => ['required', 'string', 'max:255', 'unique:bad_words,words'],
        ];
    }
}
