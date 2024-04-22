<?php

namespace App\Http\Requests;

use App\Rules\NameValidation;
use Illuminate\Foundation\Http\FormRequest;

class PostExercise extends FormRequest
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
            'exercise.*' => ['required', 'string', new NameValidation, 'max:255', 'unique:exercises,exercise'],
        ];
    }

    public function messages(): array
    {
        return [
            'exercise.*.required' => 'Please enter Exercise',

            'exercise.*.unique' => 'Exercise already exist',
        ];
    }
}
