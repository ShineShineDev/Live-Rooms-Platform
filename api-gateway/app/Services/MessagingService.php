<?php
namespace App\Services;

use App\Models\Customer;
use App\Models\Messaging;
use App\Repositories\CustomerRepository;

use App\Enums\MessagingType;
use App\Repositories\MessagingRepository;
use App\Traits\FileUpload;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use App\Traits\SendPushNotification;

class MessagingService
{


    use SendPushNotification, FileUpload;


    function unicast($request)
    {
        $customer = Customer::find($request->customer_id);
        $data = ["title" => $request->title, "body" => $request->message];
        $notification = ["title" => $request->title, "body" => $request->message];
        $this->sendAsUnicast($customer->device_token, $notification, $data);
        $input = $request->only('title', 'message', 'type', 'customer_id');
        $input['type'] ='0';
        return Messaging::create($input);
    }


    function broadcast($request)
    {
        $data = ["title" => $request->title, "body" => $request->message];
        $notification = ["title" => $request->title, "body" => $request->message];
        $this->sendAsbroadcast($notification, $data);
        $input = $request->only('title', 'message', 'type', 'customer_id');
        if ($request->image) {
            $path = $this->uploadFile($request->image, 'uploads/noti');
            $input['image_url'] = $path['path'];
        }
        return Messaging::create($input);
    }

    function histories($per_page)
    {
        return Messaging::paginate($per_page);
    }

}



