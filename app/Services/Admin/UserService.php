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

    public function register(array $userData)
    {
        return $this->userRepository->create($userData);
    }

    public function assignRole(int $userId, array $roles = [])
    {
        return $this->userRepository->find($userId)->assignRole($roles);
    }

    public function syncRoles(int $userId, array $roles = [])
    {
        return $this->userRepository->find($userId)->syncRoles($roles);
    }

    public function removeRole(int $userId, array $roles = [])
    {
        $user = $this->userRepository->find($userId);

        return collect($roles)->each(function ($role) use ($user) {
            $user->removeRole($role);
        });
    }

    public function givePermissionTo(int $userId, array $permissions = [])
    {
        return $this->userRepository->find($userId)->givePermissionTo($permissions);
    }

    public function syncPermissions(int $userId, array $permissions = [])
    {
        return $this->userRepository->find($userId)->syncPermissions($permissions);
    }

    public function revokePermissionTo(int $userId, array $permissions = [])
    {
        $user = $this->userRepository->find($userId);

        return collect($permissions)->each(function ($permission) use ($user) {
            $user->revokePermissionTo($permission);
        });
    }
}
