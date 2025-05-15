<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\NotificationRequest;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Response;

class NotificationController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function send(NotificationRequest $request)
    {
        $data = $request->validated();
        $notification = $this->notificationService->sendNotification($data);
        return Response::jsonResponse($notification, 'success', 201);
    }
}
