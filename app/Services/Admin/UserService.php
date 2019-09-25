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

    public function fetchRoles(int $id)
    {
        return $this->userRepository->find($id)->roles()->get()->pluck('id');
    }

    public function fetchPermissions(int $id)
    {
        return $this->userRepository->find($id)->permissions()->get()->pluck('id');
    }

    public function register(array $data)
    {
        if (!isset($data['password'])) {
            $data['password'] = str_random(10);
        }

        return $this->userRepository->create($data);
    }

    public function syncRoles(int $id, array $roles = [])
    {
        return $this->userRepository->find($id)->syncRoles($roles);
    }

    public function syncPermissions(int $id, array $permissions = [])
    {
        return $this->userRepository->find($id)->syncPermissions($permissions);
    }

    public function deleteUsers(int $id)
    {
        return $this->userRepository->find($id)->delete();
    }
}
