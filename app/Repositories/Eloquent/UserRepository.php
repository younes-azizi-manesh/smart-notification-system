<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(public User $user)
    {}

    public function all()
    {
        return $this->user->all();
    }
    public function find(int $id)
    {
        return $this->user->find($id);
    }
    public function findBy(string $field, string $value)
    {
        return $this->user->where($field, $value)->first();
    }
    public function create(array $user)
    {
        return $this->user->create($user);
    }
    public function update(int $id, array $data)
    {
        return $this->find($id)->update($data);
    }
    public function delete(int $id)
    {
        return $this->find($id)->delete();
    }

    public function findOrCreateByMobile(string $mobile): User
    {
        $user = $this->findBy('mobile', $mobile);

        if (!$user) {
            $user = $this->create([
                'name' => 'naqi',
                'email' => 'taqi@gmail.com',
                'password' => '1234',
                'mobile' => $mobile,
            ]);
        }

        return $user;
    }
}