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

    /**
     * @OA\Get(
     *      path="/users",
     *      tags={"Users"},
     *      summary="取得所有的 user list",
     *      description="取得所有的用戶列表",
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(response=200, description="取得 user list"),
     *      @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function getUsers()
    {
        $data = $this->service->fetchAll();

        return response()->json($data);
    }

    /**
     * @OA\Get(
     *      path="/users/{id}/roles",
     *      tags={"Users"},
     *      summary="取得 user 的所有 Roles",
     *      description="取得 user 的所有 Roles",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          description="User ID",
     *          required=true,
     *          @OA\Schema(type="integer", format="int64")
     *      ),
     *      @OA\Response(response=200, description="取得 user 的所有 Roles"),
     *      @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function getRoles(int $id)
    {
        $data = $this->service->fetchRoles($id);

        return response()->json($data);
    }

    /**
     * @OA\Get(
     *      path="/users/{id}/permissions",
     *      tags={"Users"},
     *      summary="取得 user 的所有 Permissions",
     *      description="取得 user 的所有 Permissions",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          description="User ID",
     *          required=true,
     *          @OA\Schema(type="integer", format="int64")
     *      ),
     *      @OA\Response(response=200, description="取得 user 的所有 Permissions"),
     *      @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function getPermissions(int $id)
    {
        $data = $this->service->fetchPermissions($id);

        return response()->json($data);
    }

    /**
     * @OA\Post(
     *      path="/users",
     *      tags={"Users"},
     *      summary="建立帳號",
     *      description="建立帳號",
     *      security={{"bearerAuth": {}}},
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                   required={"username", "email", "name", "nickname", "gender"},
     *                   @OA\Property(
     *                       property="username",
     *                       description="帳號",
     *                       type="string",
     *                   ),
     *                   @OA\Property(
     *                       property="email",
     *                       description="Email",
     *                       type="string",
     *                   ),
     *                  @OA\Property(
     *                      property="name",
     *                      description="姓名",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="nickname",
     *                      description="暱稱",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="gender",
     *                      description="性別",
     *                      type="string",
     *                      enum={"male", "female"}
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      description="自訂密碼，若無則系統亂數產生",
     *                      type="string",
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="新增成功"),
     *      @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function postUsers(Request $request)
    {
        $userData = $request->all();

        $data = $this->service->register($userData);

        return response()->json($data);
    }

    /**
     * @OA\Put(
     *      path="/users/{id}/roles",
     *      tags={"Users"},
     *      summary="同步 user 的 roles",
     *      description="同步 user 的 roles，達到新增、刪除 roles 的功能",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          description="User ID",
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
     * @OA\Put(
     *      path="/users/{id}/permissions",
     *      tags={"Users"},
     *      summary="同步 user 的 permissions",
     *      description="同步 user 的 permissions，達到新增、刪除 permissions 的功能",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          description="User ID",
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
     * @OA\Delete(
     *      path="/users/{id}",
     *      tags={"Users"},
     *      summary="刪除 user",
     *      description="刪除此帳號",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          description="User ID",
     *          required=true,
     *          @OA\Schema(type="integer", format="int64")
     *      ),
     *      @OA\Response(response=200, description="刪除成功"),
     *      @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function deleteUsers(int $id)
    {
        $data = $this->service->deleteUsers($id);

        return response()->json($data);
    }
}
