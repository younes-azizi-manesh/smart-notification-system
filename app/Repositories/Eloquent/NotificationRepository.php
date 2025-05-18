<?php

namespace App\Repositories\Eloquent;

use App\Models\Notification;
use App\Repositories\Contracts\NotificationRepositoryInterface;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function __construct(protected Notification $notification)
    {}
    public function all()
    {
        return $this->notification->all();
    }

    public function find($id)
    {
        return $this->notification->find($id);
    }

    public function create(array $data)
    {
        return $this->notification->create($data);
    }

    public function update($id, array $data)
    {
        $notification = $this->notification->findOrFail($id);
        $notification->update($data);
        return $notification;
    }

    public function delete($id)
    {
        return $this->notification->destroy($id);
    }

    public function findByUser($userId)
    {
        return $this->notification->where('user_id', $userId)->get();
    }

    public function expireOldPendingNotifications(\DateTimeInterface $before): int
    {
        return $this->notification->where('status', 'pending')
            ->where('created_at', '<', $before)
            ->update(['status' => 'expired']);
    }
}
