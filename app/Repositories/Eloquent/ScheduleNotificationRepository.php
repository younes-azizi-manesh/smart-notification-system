<?php

namespace App\Repositories\Eloquent;

use App\Models\ScheduledNotification;
use App\Repositories\Contracts\ScheduleNotificationRepositoryInterface;

class ScheduleNotificationRepository implements ScheduleNotificationRepositoryInterface
{
    public function __construct(public ScheduledNotification $scheduledNotification)
    {}

    public function all(array $columns = ['*'], array $with = [], array $conditions = [])
    {
        $query = $this->scheduledNotification->with($with);
        
        foreach ($conditions as $field => $value) {
            if (is_array($value)) {
                // ['view' => ['>', 100]].
                $query->where($field, $value[0], $value[1]);
            } else {
                // ['view', 100].
                $query->where($field, $value);
            }
        }
        return $query->get($columns);
    }

    public function find($id)
    {
        return $this->scheduledNotification->find($id);
    }

    public function create(array $data)
    {
        return $this->scheduledNotification->create($data);
    }

    public function update($id, array $data)
    {
        $notification = $this->scheduledNotification->findOrFail($id);
        $notification->update($data);
        return $notification;
    }

    public function delete($id)
    {
        return $this->scheduledNotification->destroy($id);
    }
}
