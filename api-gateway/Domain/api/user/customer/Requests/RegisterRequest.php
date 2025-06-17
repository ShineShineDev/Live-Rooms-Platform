<?php

namespace Domain\api\user\customer\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'nullable|email|unique:customers,email|required_without:phone',
            'phone'         => 'nullable|string|max:15|unique:customers,phone|required_without:email',
            'password'      => 'required|min:8|confirmed', 
            'gender'        => 'nullable|in:0,1',
            'dob'           => 'nullable|date',
            'post_code'     => 'nullable|string|max:10',
            'address'       => 'nullable|string|max:255',
            'avatar'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'device_token'  => 'nullable|string'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'code'    => 422,
            'message' => 'Validation failed',
            'errors'  => $validator->errors()
        ], 422));
    }
}
