<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'notification_type_id',
        'title',
        'message',
        'status',
        'sent_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(NotificationType::class, 'notification_type_id');
    }

    public function scheduled()
    {
        return $this->hasOne(ScheduledNotification::class);
    }

    public function failedLogs()
    {
        return $this->hasMany(FailedNotificationLog::class);
    }
}
