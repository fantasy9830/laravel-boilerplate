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

    /**
     * @OA\Get(
     *      path="/permissions",
     *      tags={"Permissions"},
     *      summary="取得所有的 permissions 列表",
     *      description="取得所有的 permissions 列表",
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(response=200, description="取得所有的 permissions 列表"),
     *      @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function getPermissions()
    {
        $data = $this->service->fetchAll();

        return response()->json($data);
    }

    /**
     * @OA\Post(
     *      path="/permissions",
     *      tags={"Permissions"},
     *      summary="新增 permissions",
     *      description="新增一個 permissions",
     *      security={{"bearerAuth": {}}},
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  required={"name"},
     *                  @OA\Property(
     *                      property="name",
     *                      description="permission name",
     *                      type="string",
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="新增成功"),
     *      @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function postPermissions(Request $request)
    {
        $data = $this->service->create($request->all());

        return response()->json($data);
    }

    /**
     * @OA\Put(
     *      path="/permissions/{id}/users",
     *      tags={"Permissions"},
     *      summary="同步 permission 的 users",
     *      description="同步 permission 的 users，達到新增、刪除 users 的功能",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          description="Permission ID",
     *          required=true,
     *          @OA\Schema(type="integer", format="int64")
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="users",
     *                      description="要同步的 users 陣列",
     *                      type="array",
     *                      @OA\Items(type="integer")
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="同步成功"),
     *      @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function putUsers(int $id)
    {
        $users = request('users', []);

        $data = $this->service->syncUsers($id, $users);

        return response()->json($data);
    }

    /**
     * @OA\Put(
     *      path="/permissions/{id}/roles",
     *      tags={"Permissions"},
     *      summary="同步 permission 的 roles",
     *      description="同步 permission 的 roles，達到新增、刪除 roles 的功能",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          description="Permission ID",
     *          required=true,
     *          @OA\Schema(type="integer", format="int64")
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="roles",
     *                      description="要同步的 roles 陣列",
     *                      type="array",
     *                      @OA\Items(type="integer")
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="同步成功"),
     *      @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function putRoles(int $id)
    {
        $roles = request('roles', []);

        $data = $this->service->syncRoles($id, $roles);

        return response()->json($data);
    }

    /**
     * @OA\Patch(
     *      path="/permissions/{id}",
     *      tags={"Permissions"},
     *      summary="更改 permission 的名稱",
     *      description="更改 permission 的名稱",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          description="Permission ID",
     *          required=true,
     *          @OA\Schema(type="integer", format="int64")
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  required={"name"},
     *                  @OA\Property(
     *                      property="name",
     *                      description="要更改的名稱",
     *                      type="string",
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="改名成功"),
     *      @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function patchPermissions(int $id)
    {
        $name = request('name');

        $data = $this->service->editName($id, $name);

        return response()->json($data);
    }

    /**
     * @OA\Delete(
     *      path="/permissions/{id}",
     *      tags={"Permissions"},
     *      summary="刪除 permission",
     *      description="刪除此 permission",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          description="Permission ID",
     *          required=true,
     *          @OA\Schema(type="integer", format="int64")
     *      ),
     *      @OA\Response(response=200, description="刪除成功"),
     *      @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function deletePermissions(int $id)
    {
        $data = $this->service->delete($id);

        return response()->json($data);
    }
}
