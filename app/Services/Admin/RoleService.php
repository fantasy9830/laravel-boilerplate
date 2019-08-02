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

    public function create(array $data)
    {
        return $this->roleRepository->create($data);
    }

    public function editName(int $id, string $name = '')
    {
        return $this->roleRepository->update(['name' => $name], $id);
    }

    public function syncUsers(int $id, array $users = [])
    {
        return $this->roleRepository->find($id)->user()->sync($users);
    }

    public function syncPermissions(int $id, array $permissions = [])
    {
        return $this->roleRepository->find($id)->syncPermissions($permissions);
    }

    public function delete(int $id)
    {
        return $this->roleRepository->delete($id);
    }
}
