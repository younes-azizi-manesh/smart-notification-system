<?php

use App\Http\Controllers\Api\v1\NotificationController;
use Illuminate\Support\Facades\Route;

Route::post('/notifications/send', [NotificationController::class, 'send']);