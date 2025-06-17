<?php

namespace Domain\api\user\customer\Services;

use App\Models\Customer;
use Domain\api\user\customer\Resources\LoginResource;
use Domain\api\user\customer\Resources\RegisterCustomerResource;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendNoti;

class AuthServices
{
   
    public function register($req)
    {
        $user = Customer::create($this->inputForReg($req));
        if ($user) {
            $token = $user->createToken('customer_api_token')->accessToken;
            return [
                "token" => $token,
                "customer" => new RegisterCustomerResource($user)
            ];
        }
        return false;
    }

    private function inputForReg($req)
    {
        $input = $req->only("first_name", "last_name", "email", "phone", "gender", "dob","city", "post_code", "address", "device_token");
        $input['avator'] = null;
        $input['password'] = Hash::make($req->password);
        return $input;
    }

    public function login($req)
    {
        $customer = Customer::where('email', $req->identifier)->first();
        if (!$customer)
            return 0;
        if (!Hash::check($req->password, $customer->password))
            return 1;
        $token = $customer->createToken('customer_api_token')->accessToken;
        $customer->last_logined_at = now();
        if($req->device_token != null &&  $req->device_token != ''){
            $customer->device_token = $req->device_token;
        }
        $customer->save();
        $notification = ["title" => "Login Success", "body" => 'Login Success'];
      //  SendNoti::dispatch($customer->device_token, $notification, $notification);
        return [
            "token" => $token,
            "customer" => new LoginResource($customer)
        ];
    }
}

