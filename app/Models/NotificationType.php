<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    protected $fillable = ['name'];

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function channels()
    {
        return $this->hasMany(NotificationChannel::class);
    }
}
