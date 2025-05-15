<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduledNotification extends Model
{
    protected $fillable = [
        'notification_id',
        'scheduled_for',
        'is_sent',
    ];

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }
}
