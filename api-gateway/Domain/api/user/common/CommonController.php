<?php

namespace Domain\api\user\common;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Models\Customer;
use App\Models\Favorite;
use App\Models\Messaging;
use App\Models\Setting;
use Domain\api\user\common\Resources\NotiResource;
use Illuminate\Http\Request;
use App\Jobs\TGNoti;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;

class CommonController extends Controller
{
    function toggleFavorite(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|integer|exists:customers,id',
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $favorite = Favorite::where('customer_id', $validated['customer_id'])
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($favorite) {
            $favorite->delete();
            return ApiResponse::success("Removed from favorites", null, 200);
        } else {
            $favorite = new Favorite();
            $favorite->customer_id = $validated['customer_id'];
            $favorite->product_id = $validated['product_id'];
            $favorite->save();
            return ApiResponse::success("Added to favorites", null, 200);
        }
    }



    function getNoti(Request $request)
    {
        $system = Messaging::where("type", 1)->orderByDesc("id")->get();
        $transaction = Messaging::where("customer_id", 1)->orderByDesc("id")->get();
        $notiResource = [
            "system" => NotiResource::collection($system),
            "transactions" => NotiResource::collection($transaction),
        ];
        return ApiResponse::success("Noti Lists", $notiResource, 200);
    }

    function readNoti($id)
    {
        $noti = Messaging::find($id);
        if ($noti) {
            $noti->is_read = 1;
            $noti->save();
            return ApiResponse::success("Success", new NotiResource($noti), 200);
        } else {
            return ApiResponse::success("noti not found", null, 200);
        }
    }



    function searchUserIdentifier(Request $req)
    {
        $req->validate([
            'identifier' => 'required',
        ]);
        $customer = Customer::where('phone', $req->identifier)->orWhere('email', $req->identifier)->first();
        if ($customer) {
            return ApiResponse::success("Success", $req->identifier, 200, 1);
        } else {
            return ApiResponse::success("Account Not Found !", null, 200, -1);
        }
    }
    function resetPassword(Request $req)
    {
        $req->validate(['identifier' => 'required']);
        $identifier = $req->input('identifier');
        $key = 'reset-password:' . $identifier;
        if (RateLimiter::tooManyAttempts($key, 1)) {
            return ApiResponse::success('Too many requests. Please try again in ' . RateLimiter::availableIn($key) . ' seconds.', null, 200, -1);
        }
        RateLimiter::hit($key, 60);
        $newPassword = Str::random(8);
        $customer = Customer::where('phone', $req->identifier)->orWhere('email', $req->identifier)->first();
        $customer->password = Hash::make($newPassword);
        $customer->save();
        $came_from = $req->header('came-from') ?? 'app';
        $text = $this->getMessage($customer->first_name . " " . $customer->last_name, $customer->email, $customer->phone, $newPassword, $came_from);
        TGNoti::dispatch('dd', $text, true);
        if ($customer) {
            $settings = Setting::whereIn("key", ['phone', 'mail'])->get();
            $contactInfo = '';
            foreach ($settings as $setting) {
                $contactInfo .= $setting->value . ',';
            }
            $contactInfo = rtrim($contactInfo, ',');
            return ApiResponse::success("Success", [
                'identifier' => $req->identifier,
                // 'password' => $newPassword,
                'message' => 'An administrator will provide you with a new password shortly, which will be sent directly to your account email.If you do not receive the new password within a reasonable time, feel free to contact support at ' . $contactInfo . ' for further assistance.',
            ], 200, 1);
        } else {
            return ApiResponse::success("Account Not Found !", null, 200, -1);
        }
    }

    private function getMessage($username, $mail, $phone, $new_password, $from)
    {
        return [
            "Password Forgot Request From" => $from,
            'User' => $username,
            'mail' => $mail,
            'phone' => $phone,
            'New Password' => $new_password,
        ];
    }
}
