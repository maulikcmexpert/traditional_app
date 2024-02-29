<?php

namespace App\Http\Requests\Api;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
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
            'full_name'=>['required','string','max:200'],
            'country_code'=>['required','string','max:5'],
            'mobile_number'=>['required','string','max:10','unique:users,mobile_number'],
            'email'=>['required','string','max:50','unique:users,email'],
            'user_type'=>['required','in:user,admin,organization'],
            'date_of_birth'=>['required'],
            'state'=>['required'],
            'city'=>['required'],
        ];
    }

    public function messages()
    {
        return [
            'mobile_number.required' => 'Mobile number should be string.',
            'user_type.in'=>'Type should be only user,admin,organization'
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        if (!$this->expectsJson()) {
            throw new HttpResponseException(response()->json(['status'=>false,'message' =>$validator->errors()->first()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        }
        parent::failedValidation($validator);
    }
}
