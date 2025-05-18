<?php

namespace App\Repositories\Contracts;

interface ScheduleNotificationRepositoryInterface
{
    public function all(array $columns = ['*'], array $with = [], array $conditions = []);

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}
