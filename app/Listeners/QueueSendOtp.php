<?php

namespace App\Listeners;

use App\Events\SendOtp;
use App\Jobs\SendOtpJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class QueueSendOtp implements ShouldQueue
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
    public function handle(SendOtp $event): void
    {
        SendOtpJob::dispatch($event->otp, $event->to, $event->bodyId);
    }
}
