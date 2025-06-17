<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Resources\NoitRes;
use App\Models\Messaging;
use Illuminate\Http\Request;
use App\Services\MessagingService;
use Illuminate\Support\Facades\Validator;

class MessagingController extends Controller
{
    public function index(Request $request)
    {
        
        $status = Messaging::whereNotIn("noti_for", ['order_confirm'])->orderByDesc("id")->get();
        return $status ? ApiResponse::success("Files uploaded successfully", NoitRes::collection($status), 200) :
            ApiResponse::error("No files were uploaded", 400);
     
    }
  

    public function sendAsUnicast(Request $request, MessagingService $messagingService)
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required',
            'customer_id' => 'required'
        ]);
        return $messagingService->unicast($request) ?
            back()->with('success', 'Success') :
            back()->with('fail', 'fail');
    }

    public function sendAsBroadcast(Request $request, MessagingService $messagingService)
    {
       
        $validator = $this->vali($request);
        if ($validator->fails())
            return ApiResponse::error("Validation Error", 400, $validator->errors());
        $status = $messagingService->broadcast($request);
        return $status ? ApiResponse::success("Files uploaded successfully", $status, 200) :
            ApiResponse::error("No files were uploaded", 400);

    }

    private function vali($request)
    {
        return Validator::make($request->all(), [
            "title" => ['required', 'max:255'],
            'message' => ['required']
        ]);
    }


    function delete($id)
    {
        $status = Messaging::destroy($id);
        return $status ? ApiResponse::success("Deleted", $status, 201) :
            ApiResponse::error("Deleted !", 500);
    }
}
