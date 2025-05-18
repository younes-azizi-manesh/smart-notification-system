<?php

namespace App\Console\Commands;

use App\Services\NotificationService;
use Illuminate\Console\Command;

class SendScheduledNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:send-scheduled-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send scheduled notifications';
    public function __construct(protected NotificationService $notificationService)
    {
        parent::__construct();   
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->notificationService->sendScheduledNotification();
        return COMMAND::SUCCESS;
    }
}
