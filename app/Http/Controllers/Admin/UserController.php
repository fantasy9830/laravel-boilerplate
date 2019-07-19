<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function getUsers()
    {
        $data = $this->service->fetchAll();

        return response()->json($data);
    }

    public function postUsers(Request $request)
    {
        $data = $this->service->register($request->all());

        return response()->json($data);
    }

    public function postRoles(int $userId)
    {
        $roles = request('roles', []);

        $data = $this->service->assignRole($userId, $roles);

        return response()->json($data);
    }

    public function putRoles(int $userId)
    {
        $roles = request('roles', []);

        $data = $this->service->syncRoles($userId, $roles);

        return response()->json($data);
    }

    public function postRemoveRoles(int $userId)
    {
        $roles = request('roles', []);

        $data = $this->service->removeRole($userId, $roles);

        return response()->json($data);
    }

    public function postPermissions(int $userId)
    {
        $permissions = request('permissions', []);

        $data = $this->service->givePermissionTo($userId, $permissions);

        return response()->json($data);
    }

    public function putPermissions(int $userId)
    {
        $permissions = request('permissions', []);

        $data = $this->service->syncPermissions($userId, $permissions);

        return response()->json($data);
    }

    public function postRevokePermissions(int $userId)
    {
        $permissions = request('permissions', []);

        $data = $this->service->revokePermissionTo($userId, $permissions);

        return response()->json($data);
    }
}
