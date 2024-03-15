<?php

namespace App\Http\Requests\Api;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use App\Rules\CustomEmailValidation;
use App\Rules\MobileNumberValidation;
use App\Rules\AlphaNumericCity;

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
            'full_name' => ['required', 'regex:/^[a-zA-Z0-9 ]+$/', 'string', 'max:200'],
            'country_dial' => ['required', 'string', 'max:5'],
            'mobile_number' => ['required', new MobileNumberValidation, 'string', 'unique:users,mobile_number'],
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
            'full_name.regex' => 'Full Name cannot contain special characters',
            'full_name.string' => 'Full Name should not be only digits',
            'email.required' => 'Please enter Email',
            'email.email' => 'Please enter valid Email',
            'city.required' => 'Please enter City Name',
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
