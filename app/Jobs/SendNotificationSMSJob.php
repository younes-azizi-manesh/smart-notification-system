<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Services\MelipayamakService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationSMSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = 60;

    public function __construct(
        public Notification $notification
    ) {}

    public function handle(MelipayamakService $sms): void
    {
        $sms->sendSMS(
            [$this->notification->message],
            $this->notification->user->mobile,
            314163
        );
    }
}
