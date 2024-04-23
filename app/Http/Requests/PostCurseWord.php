<?php

namespace App\Http\Requests;

use App\Rules\NameValidation;
use Illuminate\Foundation\Http\FormRequest;

class PostCurseWord extends FormRequest
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
            'curse_word.*' => ['required', 'string', new NameValidation, 'max:255', 'unique:bad_words,words'],
        ];
    }

    public function messages(): array
    {
        return [
            'curse_word.*.required' => 'Please enter Curse Word',

            'curse_word.*.unique' => 'Curse Word already exist',
        ];
    }
}
