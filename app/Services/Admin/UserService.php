<?php

namespace App\Services\Admin;

use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function fetchAll()
    {
        return $this->userRepository->all();
    }

    public function register(array $data)
    {
        if (!isset($data['password'])) {
            $data['password'] = str_random(10);
        }

        return $this->userRepository->create($data);
    }

    public function syncRoles(int $userId, array $roles = [])
    {
        return $this->userRepository->find($userId)->syncRoles($roles);
    }

    public function syncPermissions(int $userId, array $permissions = [])
    {
        return $this->userRepository->find($userId)->syncPermissions($permissions);
    }

    public function deleteUsers(int $id)
    {
        return $this->userRepository->find($id)->delete();
    }
}
