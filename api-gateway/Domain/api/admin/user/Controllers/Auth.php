<?php

namespace Domain\api\admin\user\Controllers;
use App\Http\Helpers\ApiResponse;


use Domain\api\admin\user\Services\AuthServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
trait Auth
{
    function register(Request $request, AuthServices $authServices)
    {
        $validator = $this->regValidation($request);
        if ($validator->fails()) {
            return ApiResponse::error('Validation Failed', 422,$validator->errors());
        }
        $status = $authServices->register($request);
        if ($status)
            return ApiResponse::success("Register Success", $status, 201);
        if ($status)
            return ApiResponse::error("Register Fail", $status, 500);
    }
    function login(Request $request, AuthServices $authServices)
    {
        $validator = $this->loginValidation($request);
        if ($validator->fails()) {
            return ApiResponse::error('Validation Failed', 422,$validator->errors());
        }
        $status = $authServices->login($request);
        if ($status == 0)
            return ApiResponse::error("Phone number or email not found ", 422);
        if ($status == 1)
            return ApiResponse::error("Incorrect Password ", 422);
        return ApiResponse::success("Login Success", $status, 200);
    }
    private function loginValidation($request)
    {
        return Validator::make($request->all(), [
            'identifier' => 'required',
            'password' => 'required',
        ]);
    }

    private function regValidation($request)
    {
        return Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',  
            'password' => 'required',
        ]);
    }
}
