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

    /**
     * @OA\Get(
     *      path="/roles",
     *      tags={"Roles"},
     *      summary="取得所有的 roles 列表",
     *      description="取得所有的 roles 列表",
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(response=200, description="取得所有的 roles 列表"),
     *      @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function getRoles()
    {
        $data = $this->service->fetchAll();

        return response()->json($data);
    }

    /**
     * @OA\Post(
     *      path="/roles",
     *      tags={"Roles"},
     *      summary="新增 role",
     *      description="新增一個 role",
     *      security={{"bearerAuth": {}}},
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  required={"name"},
     *                  @OA\Property(
     *                      property="name",
     *                      description="role name",
     *                      type="string",
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="新增成功"),
     *      @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function postRoles(Request $request)
    {
        $data = $this->service->create($request->all());

        return response()->json($data);
    }

    /**
     * @OA\Put(
     *      path="/roles/{id}/users",
     *      tags={"Roles"},
     *      summary="同步 role 的 users",
     *      description="同步 role 的 users，達到新增、刪除 users 的功能",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          description="Role ID",
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
     *      path="/roles/{id}/permissions",
     *      tags={"Roles"},
     *      summary="同步 role 的 permissions",
     *      description="同步 role 的 permissions，達到新增、刪除 permissions 的功能",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          description="Role ID",
     *          required=true,
     *          @OA\Schema(type="integer", format="int64")
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="permissions",
     *                      description="要同步的 permissions 陣列",
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
    public function putPermissions(int $id)
    {
        $permissions = request('permissions', []);

        $data = $this->service->syncPermissions($id, $permissions);

        return response()->json($data);
    }

    /**
     * @OA\Patch(
     *      path="/roles/{id}",
     *      tags={"Roles"},
     *      summary="更改 role 的名稱",
     *      description="更改 role 的名稱",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          description="Role ID",
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
    public function patchRoles(int $id)
    {
        $name = request('name');

        $data = $this->service->editName($id, $name);

        return response()->json($data);
    }

    /**
     * @OA\Delete(
     *      path="/roles/{id}",
     *      tags={"Roles"},
     *      summary="刪除 role",
     *      description="刪除此 role",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          description="Role ID",
     *          required=true,
     *          @OA\Schema(type="integer", format="int64")
     *      ),
     *      @OA\Response(response=200, description="刪除成功"),
     *      @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function deleteRoles(int $id)
    {
        $data = $this->service->delete($id);

        return response()->json($data);
    }
}
