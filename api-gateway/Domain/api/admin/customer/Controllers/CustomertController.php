<?php

namespace Domain\api\admin\customer\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Models\Customer;

use Illuminate\Http\Request;
use Carbon\Carbon;


class CustomertController extends Controller
{

    public function filter(Request $request)
    {
        $query = Customer::orderByDesc("id");

        if ($request->gender) {
            $query->where("gender", $request->gender);
        }

        if ($request->phone) {
            $query->where("phone", "LIKE", "%{$request->phone}%");
        }

        $customers = $request->limit ? $query->paginate($request->limit) : $query->paginate(50);

        if ($customers->count() > 0) {
            return ApiResponse::success("Customers", $customers, 200);
        } else {
            return ApiResponse::error("No customers found", 404);
        }

    }
}
