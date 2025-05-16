<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $user);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function findOrCreateByMobile(string $mobile): User;
}