<?php

namespace App\Http\Requests\Api;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use App\Rules\CustomEmailValidation;
use App\Rules\MobileNumberValidation;
use App\Rules\AlphaNumericCity;
use App\Rules\FullNameValidation;


class UserValidate extends FormRequest
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
            'full_name' => [
                'required',
                new FullNameValidation,
                'max:200'
            ],
            'country_dial' => ['required', 'string', 'max:5'],
            'mobile_number' => ['required', new MobileNumberValidation, 'unique:users,mobile_number'],
            'email' => ['required', 'email', new CustomEmailValidation, 'max:50', 'unique:users,email'],
            'date_of_birth' => ['required'],
            'state_id' => ['required', 'integer'],
            'city' => ['required', new AlphaNumericCity],
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Please enter Full Name',
            'email.required' => 'Please enter Email',
            'email.email' => 'Please enter valid Email',
            'city.required' => 'Please enter City',
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        if (!$this->expectsJson()) {
            throw new HttpResponseException(response()->json(['status' => false, 'message' => $validator->errors()->first()], JsonResponse::HTTP_OK));
        }
        parent::failedValidation($validator);
    }
}
