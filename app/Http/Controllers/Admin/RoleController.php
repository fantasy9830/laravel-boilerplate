<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    public function getRoles()
    {
        $data = $this->service->fetchAll();

        return response()->json($data);
    }

    public function postRoles(Request $request)
    {
        $data = $this->service->create($request->all());

        return response()->json($data);
    }

    public function patchRolesName(int $roleId)
    {
        $name = request('name');

        $data = $this->service->editName($roleId, $name);

        return response()->json($data);
    }

    public function postPermissions(int $roleId)
    {
        $permissions = request('permissions');

        $data = $this->service->givePermissionTo($roleId, $permissions);

        return response()->json($data);
    }

    public function putPermissions(int $roleId)
    {
        $permissions = request('permissions');

        $data = $this->service->syncPermissions($roleId, $permissions);

        return response()->json($data);
    }

    public function postRevokePermissions(int $roleId)
    {
        $permissions = request('permissions');

        $data = $this->service->revokePermissionTo($roleId, $permissions);

        return response()->json($data);
    }

    public function deleteRoles(int $roleId)
    {
        $data = $this->service->delete($roleId);

        return response()->json($data);
    }
}
