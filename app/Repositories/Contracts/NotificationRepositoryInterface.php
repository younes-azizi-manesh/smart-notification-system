<?php

namespace App\Repositories\Contracts;

interface NotificationRepositoryInterface
{
    public function all();

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function findByUser($userId);

    public function expireOldPendingNotifications(\DateTimeInterface $before): int;
}
