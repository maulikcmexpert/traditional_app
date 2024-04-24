<?php

namespace App\Http\Requests;

use App\Rules\NameValidation;
use Illuminate\Foundation\Http\FormRequest;

class PostLeaveReason extends FormRequest
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
            'leave_reason.*' => ['required', 'string', new NameValidation, 'max:255', 'unique:leave_reasons,reason'],
        ];
    }

    public function messages(): array
    {
        return [
            'leave_reason.*.required' => 'Please enter Leave Reason',

            'leave_reason.*.unique' => 'Leave Reason already exist',
        ];
    }
}
