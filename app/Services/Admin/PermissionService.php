<?php

namespace App\Services\Admin;

use App\Repositories\PermissionRepository;

class PermissionService
{
    protected $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function fetchAll()
    {
        return $this->permissionRepository->all();
    }

    public function create(array $permissionData)
    {
        return $this->permissionRepository->create($permissionData);
    }

    public function editName(int $permissionId, string $name = '')
    {
        return $this->permissionRepository->update(['name' => $name], $permissionId);
    }

    public function assignRole(int $permissionId, array $roles = [])
    {
        return $this->permissionRepository->find($permissionId)->assignRole($roles);
    }

    public function syncRoles(int $permissionId, array $roles = [])
    {
        return $this->permissionRepository->find($permissionId)->syncRoles($roles);
    }

    public function removeRole(int $permissionId, array $roles = [])
    {
        $permission = $this->permissionRepository->find($permissionId);

        return collect($roles)->each(function ($role) use ($permission) {
            $permission->removeRole($role);
        });
    }

    public function delete(int $permissionId)
    {
        return $this->permissionRepository->delete($permissionId);
    }
}
