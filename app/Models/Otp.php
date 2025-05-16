<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = 
    [
        'token',
        'user_id',
        'otp_code',
        'login_id',
        'type',
        'used'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
