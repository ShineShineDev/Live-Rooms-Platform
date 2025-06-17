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

class TGNoti implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,  SendPushNotification;

    protected $chat_id;
    protected $text;
    protected $isDataArray;

    protected $replyMarkup;

    public function __construct($chat_id, $text, $isDataArray = false,$replyMarkup = null)
    {
        $this->chat_id = $chat_id;
        $this->text = $text;
        $this->isDataArray = $isDataArray;
        $this->replyMarkup = $replyMarkup;
    }
    public function handle()
    {
        $text = $this->text;
        if($this->isDataArray){
            $text = $this->renderHtml($this->text);
        }
        $data = [
            'chat_id'    => -4777211403,
            'text'       => $text,
            'parse_mode' => 'HTML',
        ];
        if($this->replyMarkup != null){
            $data['reply_markup'] = $this->replyMarkup;
        }
        $res =  Http::post("https://api.telegram.org//sendMessage", $data);
    }

    function renderHtml(array $data): string
    {
        $html = '';
        foreach ($data as $label => $value) {
            $html .= "<b>{$label} : </b>{$value}\n";
        }
        return $html;
    }
    // 'inline_keyboard'     => [
    //     [
    //         ['text' => 'dd', 'url' => 'dd'],
    //     ],
    // ],
}
