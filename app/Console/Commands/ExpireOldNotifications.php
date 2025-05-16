<?php

namespace App\Console\Commands;

use App\Repositories\Contracts\NotificationRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpireOldNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:expire-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark pending notifications older than 24 hours as expired';
    public function __construct(
        protected NotificationRepositoryInterface $notificationRepository
    ) {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredCount = $this->notificationRepository->expireOldPendingNotifications(Carbon::now()->subDay());

        $this->info("$expiredCount notifications marked as expired.");

        return Command::SUCCESS;
    }
}
