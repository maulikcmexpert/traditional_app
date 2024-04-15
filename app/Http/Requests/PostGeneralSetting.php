<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostGeneralSetting extends FormRequest
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
            'min_age' => ['required', 'numeric'],
            'max_age' => ['required', 'numeric'],
            'ghost_count' => ['required', 'numeric'],
            'ghost_day' => ['required', 'numeric'],
            'no_chat_day_duration' => ['required', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'min_age.required' => 'Please enter minimum age.',
            'max_age.required' => 'Please enter maximum age.',
            'ghost_count.required' => 'Please enter ghost count.',
            'ghost_day.required' => 'Please enter ghost day.',
            'no_chat_day_duration.required' => 'Please enter No Chat Day Duration.',
            '*.numeric' => ':attribute must be a number.',
        ];
    }
}
