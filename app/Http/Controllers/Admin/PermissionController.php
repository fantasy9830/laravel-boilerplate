<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $service;

    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }

    public function getPermissions()
    {
        $data = $this->service->fetchAll();

        return response()->json($data);
    }

    public function postPermissions(Request $request)
    {
        $data = $this->service->create($request->all());

        return response()->json($data);
    }

    public function patchPermissionsName(int $permissionId)
    {
        $name = request('name');

        $data = $this->service->editName($permissionId, $name);

        return response()->json($data);
    }

    public function postRoles(int $permissionId)
    {
        $roles = request('roles');

        $data = $this->service->assignRole($permissionId, $roles);

        return response()->json($data);
    }

    public function putRoles(int $permissionId)
    {
        $roles = request('roles');

        $data = $this->service->syncRoles($permissionId, $roles);

        return response()->json($data);
    }

    public function postRemoveRoles(int $permissionId)
    {
        $roles = request('roles');

        $data = $this->service->removeRole($permissionId, $roles);

        return response()->json($data);
    }

    public function deletePermissions(int $permissionId)
    {
        $data = $this->service->delete($permissionId);

        return response()->json($data);
    }
}
