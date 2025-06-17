<?php

namespace Domain\api\user\customer\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;


use App\Models\Customer;

use Domain\api\user\customer\Resources\LoginResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class CustomerController extends Controller
{
    use Auth;

    function profile(Request $request)
    {
        $user = Customer::find($request->user()->id);
        return ApiResponse::success("Profile", new LoginResource($user), 200);
    }

    function update(Request $request)
    {
        $customer = Customer::find($request->customer_id);

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email,' . $customer->id . '|required_without:phone',
            'phone' => 'nullable|string|max:15|unique:customers,phone,' . $customer->id . '|required_without:email',
            'gender' => 'nullable|in:0,1',
            'dob' => 'nullable|date',
            "city" => 'nullable',
            'post_code' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
        ]);
        $customer->update($request->only([
            'first_name',
            'last_name',
            'email',
            'phone',
            'gender',
            'dob',
            'city', 
            'post_code',
            'address'
        ]));
        return ApiResponse::success("Updated", new LoginResource($customer), 200);
    }

   

    function delete(Request $request)
    {
        $request->validate(['customer_id' => 'required|exists:customers,id']);
        $customer = Customer::find($request->customer_id);
        $customer->status = "inactive";
        $customer->save();
        return ApiResponse::success("Account Deleted", null, 200);
    }

    function updatePassword(Request $request)
    {
        $request->validate([
            "old_password" => 'required|min:6',
            'new_password' => 'required|min:6|confirmed'
        ]);
        $customer = Customer::find($request->user()->id);
        if (!Hash::check($request->old_password, $customer->password))
            return ApiResponse::success("Password Incorrect", null, 401);

        $customer->password = Hash::make($request->new_password);
        $customer->save();
        return ApiResponse::success("Password Updated", null, 200);
    }


    public function updateAvatar(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $customer = Customer::find($request->customer_id);

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');

            if ($customer->avatar && file_exists(storage_path('app/public/' . $customer->avatar))) {
                unlink(storage_path('app/public/' . $customer->avatar));
            }
            $customer->avatar = $avatarPath;
            $customer->save();
        } else {
            return ApiResponse::error("Invalid file or no file uploaded", 400);
        }

        return ApiResponse::success("Profile Updated", new LoginResource($customer), 200);
    }
}

