<?php

namespace App\Services;

use App\Jobs\SendNotificationJob;
use App\Repositories\Contracts\NotificationRepositoryInterface;

class NotificationService
{
    public function __construct(
        protected NotificationRepositoryInterface $notificationRepo
    ) {}

    public function sendNotification(array $data)
    {
        $notification = $this->notificationRepo->create([
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'message' => $data['message'],
            'notification_type_id' => $data['notification_type_id'],
            'status' => 'pending',
        ]);

        SendNotificationJob::dispatch($notification);
        return $notification;
    }

    public function getUserNotifications(int $userId)
    {
        return $this->notificationRepo->findByUser($userId);
    }

    public function updateStatus(int $id, string $status)
    {
        return $this->notificationRepo->update($id, [
            'status' => $status,
        ]);
    }
}
