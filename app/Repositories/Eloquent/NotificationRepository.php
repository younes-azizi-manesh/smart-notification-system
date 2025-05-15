<?php

namespace App\Repositories\Eloquent;

use App\Models\Notification;
use App\Repositories\Contracts\NotificationRepositoryInterface;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function all()
    {
        return Notification::all();
    }

    public function find($id)
    {
        return Notification::find($id);
    }

    public function create(array $data)
    {
        return Notification::create($data);
    }

    public function update($id, array $data)
    {
        $notification = Notification::findOrFail($id);
        $notification->update($data);
        return $notification;
    }

    public function delete($id)
    {
        return Notification::destroy($id);
    }

    public function findByUser($userId)
    {
        return Notification::where('user_id', $userId)->get();
    }

    public function expireOldPendingNotifications(\DateTimeInterface $before): int
    {
        return Notification::where('status', 'pending')
            ->where('created_at', '<', $before)
            ->update(['status' => 'expired']);
    }
}
