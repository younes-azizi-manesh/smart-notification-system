<?php

namespace App\Jobs;

use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Notification $notification) {}

    public $tries = 3;
    public $backoff = 60;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->notification->update(['status' => 'sent']);
        Log::info("Sending notification ID {$this->notification->id} to user {$this->notification->user_id}");
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
