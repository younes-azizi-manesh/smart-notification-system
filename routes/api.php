<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\NotificationController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:sanctum')->group(function () {
    Route::post('/login-register', [AuthController::class, 'loginRegister']);
    Route::post('/login-confirm', [AuthController::class, 'loginConfirm']);
    Route::post('/login-resend-otp', [AuthController::class, 'loginResendOtp']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->withoutMiddleware('guest:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/notifications/send', [NotificationController::class, 'send']);
    Route::post('/notifications/scheduled-notification', [NotificationController::class, 'scheduledNotification']);
    Route::post('/notifications/get', [NotificationController::class, 'getNotifications']);
});
