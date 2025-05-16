<?php

namespace App\Jobs;

use App\Services\MelipayamakService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendOtpJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $otp, public string $to, public int $bodyId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(MelipayamakService $sms): void
    {
        $sms->sendSMS($this->otp, $this->to, $this->bodyId);
    }

    public function failed(\Throwable $exception)
    {
        logger()->error('Notification failed after retries', [
            'error' => $exception->getMessage(),
        ]);
    }
}
