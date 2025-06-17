<?php

namespace App\Http\Controllers;

use App\Traits\SendPushNotification;


class HomeController extends Controller
{
    use SendPushNotification;
    public function noti()
    {
        // $data = ["title" => 'testing', "body" => 'testing'];
        // $this->sendAsbroadcast($data,$data);
        // $this->sendAsUnicast($data,$data);
    }
}
