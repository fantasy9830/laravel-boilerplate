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

    public function editName(int $id, string $name = '')
    {
        return $this->permissionRepository->update(['name' => $name], $id);
    }

    public function syncUsers(int $id, array $users = [])
    {
        return $this->permissionRepository->find($id)->user()->sync($users);
    }

    public function syncRoles(int $id, array $roles = [])
    {
        return $this->permissionRepository->find($id)->syncRoles($roles);
    }

    public function delete(int $id)
    {
        return $this->permissionRepository->delete($id);
    }
}
