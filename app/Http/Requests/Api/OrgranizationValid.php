<?php

namespace App\Http\Requests\Api;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use App\Rules\CustomEmailValidation;
use App\Rules\MobileNumberValidation;
use App\Rules\OrganizationNameValidation;
use App\Rules\AlphaNumericCity;

use App\Rules\AddressValidation;

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
            'organization_name' => ['required', new OrganizationNameValidation, 'max:200'],
            'country_code' => ['required', 'string', 'max:5'],
            'mobile_number' => ['required', new MobileNumberValidation, 'string', 'unique:users,mobile_number'],
            'email' => ['required', 'email', new CustomEmailValidation, 'max:50', 'unique:users,email'],
            'organization_profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'established_year' => ['required'],
            'size_of_organization' => ['required', 'exists:size_of_organizations,id'],
            'state_id' => ['required', 'integer'],
            'city' => ['required', new AlphaNumericCity],
            'address' => ['required', new AddressValidation],

        ];
    }

    public function messages()
    {
        return [
            'organization_name.required' => 'Please enter Organization Name',
            'mobile_number.required' => 'Please enter Mobile Number',
            'email.required' => 'Please enter Email',
            'organization_profile.required' => 'Please upload Logo/Image',
            'email.email' => 'Please enter valid Email',
            'established_year.required' => 'Please select Established Year',
            'city.required' => 'Please enter City Name',
            'city.regex' => 'Please enter valid City Name',
            'address' => 'Please enter Address'
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
