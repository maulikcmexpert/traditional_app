<?php

namespace App\Http\Requests\Api;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use App\Rules\CustomEmailValidation;
use App\Rules\MobileNumberValidation;


class OrgranizationValid extends FormRequest
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
            'organization_name' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:200'],
            'country_code' => ['required', 'string', 'max:5'],
            'mobile_number' => ['required', new MobileNumberValidation, 'string', 'unique:users,mobile_number'],
            'email' => ['required', 'email', new CustomEmailValidation, 'max:50', 'unique:users,email'],
            'organization_profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'established_year' => ['required'],
            'size_of_organization' => ['required', 'exists:size_of_organizations,id'],
            'state_id' => ['required', 'integer'],
            'city' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'address' => ['required', 'regex:/^[a-zA-Z\s]+$/'],

        ];
    }

    public function messages()
    {
        return [
            'organization_name.regex' => 'Please enter Organization Name must be start with character',
            'mobile_number.required' => 'Mobile number should be string.',
            // 'user_type.in'=>'Type should be only user,admin,organization'
            'city.required' => 'Plesse enter City',
            'city.regex' => ['Please enter City must be start with character'],
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
