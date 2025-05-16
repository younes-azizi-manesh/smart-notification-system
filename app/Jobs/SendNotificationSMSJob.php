<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Services\MelipayamakService;
use Exception;
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

    public function handle(MelipayamakService $sms)
    {
        $sms->sendSMS(
            [$this->notification->message],
            $this->notification->user->mobile,
            314163
        );
        $this->notification->update(['status' => 'failed']);
    }

    public function failed(\Throwable $exception)
    {
        $this->notification->update(['status' => 'failed']);

        logger()->error('Notification failed after retries', [
            'id' => $this->notification->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
