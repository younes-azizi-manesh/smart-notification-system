<?php

namespace App\Listeners;

use App\Events\NotificationCreated;
use App\Jobs\SendNotificationSMSJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class QueueNotificationSending implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NotificationCreated $event): void
    {
        SendNotificationSMSJob::dispatch($event->notification);
    }
}
