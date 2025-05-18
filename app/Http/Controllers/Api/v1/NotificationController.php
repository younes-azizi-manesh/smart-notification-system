<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\NotificationRequest;
use App\Http\Requests\Api\ScheduledNotificationRequest;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Response;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $notificationService)
    {}

    public function send(NotificationRequest $request)
    {
        $data = $request->validated();
        $notification = $this->notificationService->sendNotification($data);
        return Response::jsonResponse($notification, 'success', 201);
    }

    public function getNotifications()
    {   
        $notifications = $this->notificationService->getNotifications();
        return Response::jsonResponse($notifications, 'success', 200);
    }
    // set schedule notification
    public function scheduledNotification(ScheduledNotificationRequest $request)
    {   
        $validated = $request->validated();
        $notification = $this->notificationService->find($validated['notification_id']);
        $scheduled = $this->notificationService->setScheduledNotification($notification, $validated['scheduled_for']);
        return Response::jsonResponse($scheduled, 'success', 200);
    }
}
