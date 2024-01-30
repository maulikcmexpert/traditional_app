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
            'name'=>['required','string','max:200'],
            'mobile'=>['required','string','max:10','unique:users,mobile'],
            'country_code'=>['required','string','max:5'],
            'email'=>['required','string','max:50','unique:users,email'],
            'role'=>['required','in:learner,educator,host,institute,company'],
        ];
    }

    public function messages()
    {
        return [           
            'mobile.required' => 'Mobile number should be string.',
            'role.in'=>'Role should be only learner,educator,host,institute Or company'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
       
        if (!$this->expectsJson()) {
            throw new HttpResponseException(response()->json(['status'=>false,'message' =>'Validation error','data' => $validator->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        }
        
        parent::failedValidation($validator);
    }
}