<?php

namespace App\Jobs;

use App\Models\ScheduledNotification;
use App\Services\MelipayamakService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendScheduledNotificationJob implements ShouldQueue
{
    use Queueable;

    public $tries = 3;
    public $backoff = 60;
    /**
     * Create a new job instance.
     */
    public function __construct(protected ScheduledNotification $scheduledNotification)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(MelipayamakService $sms): void
    {
        $notification = $this->scheduledNotification->notification;
        $sms->sendSMS([$notification->message], $notification->user->mobile, 314163);
        $this->scheduledNotification->update(['is_sent' => true]);
    }

    public function failed(\Throwable $exception)
    {
        logger()->error('Notification failed after retries', [
            'error' => $exception->getMessage(),
        ]);
    }
}
