<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Traits\SendPushNotification;
class SendNoti implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,  SendPushNotification;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $deviceToken;
    protected $notification;
    protected $data;

    public function __construct($deviceToken, array $notification, array $data = [])
    {
        $this->deviceToken = $deviceToken;
        $this->notification = $notification;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendAsUnicast($this->deviceToken,$this->notification,$this->notification);
    }
}
