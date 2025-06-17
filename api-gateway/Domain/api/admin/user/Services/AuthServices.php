<?php

namespace Domain\api\admin\user\Services;

use App\Models\User;
use App\Traits\SendPushNotification;
use Illuminate\Support\Facades\Hash;

class AuthServices
{
    use SendPushNotification;
    public function register($req)
    {
        $input = $req->only("name", "email");
        $input['password'] = Hash::make($req->password);
        $user = User::create($input);
        if ($user) {
            return [
                "user" => $user
            ];
        }
        return false;
    }

    public function login($req)
    {
        $customer = User::where('email', $req->identifier)->first();
        if (!$customer)
            return 0;
        if (!Hash::check($req->password, $customer->password))
            return 1;

        $token = $customer->createToken('admin_api_token')->accessToken;
        // $customer->last_logined_at = now();
        // $customer->device_token = $req->device_token;
        // $customer->save();
        $notification = ["title" => "Login Success", "body" => 'Login Success'];
        $this->sendAsUnicast($req->device_token,$notification,$notification);
        return [
            "token" => $token,
            "user" => $customer
        ];
    }


}

