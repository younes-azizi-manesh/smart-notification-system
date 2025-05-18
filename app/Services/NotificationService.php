<?php

namespace App\Services;

use App\Events\NewScheduledNotification;
use App\Events\NotificationCreated;
use App\Models\Notification;
use App\Repositories\Contracts\NotificationRepositoryInterface;
use App\Repositories\Contracts\ScheduleNotificationRepositoryInterface;

class NotificationService
{
    public function __construct(
        protected NotificationRepositoryInterface $notificationRepo,
        protected ScheduleNotificationRepositoryInterface $scheduleNotification
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

        event(new NotificationCreated($notification));
        return $notification;
    }

    public function getUserNotifications(int $userId)
    {
        return $this->notificationRepo->findByUser($userId);
    }
    public function getNotifications()
    {
        return $this->notificationRepo->all();
    }

    public function updateStatus(int $id, string $status)
    {
        return $this->notificationRepo->update($id, [
            'status' => $status,
        ]);
    }
    public function find(int $id)
    {
        return $this->notificationRepo->find($id);
    }

    public function setScheduledNotification(Notification $notification, $timestamp)
    {
        $data = [  
        'notification_id' => $notification->id,
        'scheduled_for' => $timestamp,
        'is_sent' => false,
        ];
        $scheduledNotification = $this->scheduleNotification->create($data);
        return ['scheduledNotification' => $scheduledNotification, 'success' => true];
    }
    public function sendScheduledNotification()
    {
        $scheduledNotifications = $this->scheduleNotification->all(with: ['notification.user'], conditions: ['is_sent' => false, 'scheduled_for' => ['<=', now()],]);
        foreach($scheduledNotifications as $scheduledNotification)
        {
            event(new NewScheduledNotification($scheduledNotification));
        }
    }
}
