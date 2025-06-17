<?php

namespace Domain\api\admin\user\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;


use App\Models\Customer;
use App\Models\User;
use Domain\api\user\customer\Resources\RegisterCustomerResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use Auth;

    function profile(Request $request)
    {
        return ApiResponse::success("Profile", new RegisterCustomerResource($request->user()), 200);
    }


    function delete(Request $request)
    {
        $request->validate(['customer_id' => 'required|exists:customers,id']);
        $customer = Customer::find($request->customer_id);
        $customer->status = "inactive";
        $customer->save();
        return ApiResponse::success("Account Deleted", null, 200);
    }

    function getAdmins(Request $request, User $user){
        $user = $user->get();
        return ApiResponse::success("Request Success", $user, 200);
    }
}
