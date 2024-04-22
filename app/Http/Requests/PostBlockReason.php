<?php

namespace App\Http\Requests;

use App\Rules\NameValidation;
use Illuminate\Foundation\Http\FormRequest;

class PostBlockReason extends FormRequest
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
            'reason.*' => ['required', 'string', new NameValidation, 'max:255', 'unique:block_reasons,reason'],
        ];
    }

    public function messages(): array
    {
        return [
            'reason.*.required' => 'Please enter Block Reason',

            'reason.*.unique' => 'Block Reason already exist',
        ];
    }
}
