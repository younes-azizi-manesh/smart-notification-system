<?php
namespace App\Repositories\Contracts;

interface OtpRepositoryInterface
{
    public function find(int $id);
    public function findBy(string $field, string $value);
    public function create(array $otp);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function findWhere(array $conditions = [], array $with = [], array $columns = ['*']);
}