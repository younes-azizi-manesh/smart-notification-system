<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $fillable = [
        'user_id',
        'receive_email',
        'receive_sms',
        'receive_in_app',
        'preferred_channel',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
