<?php

namespace App\Services\Admin;

use App\Repositories\RoleRepository;

class RoleService
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function fetchAll()
    {
        return $this->roleRepository->all();
    }

    public function create(array $roleData)
    {
        return $this->roleRepository->create($roleData);
    }

    public function editName(int $roleId, string $name = '')
    {
        return $this->roleRepository->update(['name' => $name], $roleId);
    }

    public function givePermissionTo(int $roleId, array $permissions = [])
    {
        return $this->roleRepository->find($roleId)->givePermissionTo($permissions);
    }

    public function syncPermissions(int $roleId, array $permissions = [])
    {
        return $this->roleRepository->find($roleId)->syncPermissions($permissions);
    }

    public function revokePermissionTo(int $roleId, array $permissions = [])
    {
        $role = $this->roleRepository->find($roleId);

        return collect($permissions)->each(function ($permission) use ($role) {
            $role->revokePermissionTo($permission);
        });
    }

    public function delete(int $roleId)
    {
        return $this->roleRepository->delete($roleId);
    }
}
