<?php

namespace App\Listeners;

use App\Events\NewScheduledNotification;
use App\Jobs\SendScheduledNotificationJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class QueueNewScheduledNotification
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
    public function handle(NewScheduledNotification $event): void
    {
        SendScheduledNotificationJob::dispatch($event->scheduledNotification);
    }
}
