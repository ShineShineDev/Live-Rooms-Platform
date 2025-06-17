<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Traits\SendPushNotification;
use Illuminate\Support\Facades\Http;

class TGPhotoNoti implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,  SendPushNotification;

    protected $photo;
    protected $caption;
    protected $isDataArray;

    protected $replyMarkup;

    public function __construct($photo, $caption, $isDataArray = false,$replyMarkup = null)
    {
        $this->photo = $photo;
        $this->caption = $caption;
        $this->isDataArray = $isDataArray;
        $this->replyMarkup = $replyMarkup;
    }
    public function handle()
    {
        $caption = $this->caption;
        if($this->isDataArray){
            $caption = $this->renderHtml($this->caption);
        }
        $data = [
            'chat_id'    => -4777211403,
            'photo' => $this->photo,
            'caption'       => $caption,
            'parse_mode' => 'HTML',
        ];
        if($this->replyMarkup != null){
            $data['reply_markup'] = $this->replyMarkup;
        }
        $res =  Http::post("https://api.telegram.org//sendPhoto", $data);
    }

    function renderHtml(array $data): string
    {
        $html = '';
        foreach ($data as $label => $value) {
            $html .= "<b>{$label} : </b>{$value}\n";
        }
        return $html;
    }
}
