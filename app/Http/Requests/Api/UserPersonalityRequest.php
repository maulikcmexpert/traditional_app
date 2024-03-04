<?php


namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UserPersonalityRequest extends FormRequest
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
            'life_styles' => ['required', 'array'],
            'life_styles.*' => ['integer'],
            'interest_and_hobby' => ['required', 'array'],
            'interest_and_hobby.*' => ['integer'],
            'zodiac_id' => ['required', 'integer']

        ];
    }
}
