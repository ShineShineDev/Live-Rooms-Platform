<?php

namespace Domain\api\user\customer\Controllers;
use App\Http\Helpers\ApiResponse;
use Domain\api\user\customer\Requests\RegisterRequest;
use Domain\api\user\customer\Services\AuthServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
trait Auth
{
    function register(RegisterRequest $request, AuthServices $authServices)
    {
        $status = $authServices->register($request);
        if ($status)
            return ApiResponse::success("Register Success", $status, 201);
        if ($status)
            return ApiResponse::error("Register Fail", $status, 500);
    }
    function login(Request $request, AuthServices $authServices)
    {
        $this->loginValidation($request);
        $status = $authServices->login($request);
        if ($status == 0)
            return ApiResponse::error("Phone number or email not found ", 401);
        if ($status == 1)
            return ApiResponse::error("Incorrect Password ", 401);
        return ApiResponse::success("Login Success", $status, 200);
    }
    private function loginValidation($request)
    {
        return Validator::make($request->all(), [
            'identifier' => 'required',
            'password' => 'required',
            "device_token" => 'nullable'
        ]);
    }
}
