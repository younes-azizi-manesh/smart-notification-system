<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FailedNotificationLog extends Model
{
    protected $fillable = [
        'notification_id',
        'error_message',
        'failed_at',
    ];

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }
}
