<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/v1')->group(function () {
    // login
    Route::post('/auth/token', 'AuthController@postToken');
    // register
    // Route::post('/registration', 'AuthController@postRegister');

    // 檢查JWT Token
    Route::middleware('auth.token')->group(function () {
        // 個人用戶相關API
        Route::prefix('/user')->group(function () {
            // 個人資料
            Route::get('/profile', 'PersonalController@getProfile');
        });

        // 管理者相關API
        Route::middleware('role:admin')->namespace('Admin')->group(function () {
            // 用戶管理
            Route::prefix('/users')->group(function () {
                // 用戶列表
                Route::get('/', 'UserController@getUsers');
                // 新增用戶
                Route::post('/registration', 'UserController@postRegister');
                // 指派角色
                Route::post('/{userId}/roles', 'UserController@postRoles');
                // 同步角色
                Route::put('/{userId}/roles', 'UserController@putRoles');
                // 取消角色(多筆)
                Route::post('/{userId}/remove-roles', 'UserController@postRemoveRoles');
                // 指派權限
                Route::post('/{userId}/permissions', 'UserController@postPermissions');
                // 同步權限
                Route::put('/{userId}/permissions', 'UserController@putPermissions');
                // 取消權限(多筆)
                Route::post('/{userId}/revoke-permissions', 'UserController@postRevokePermissions');
            });

            // 角色管理
            Route::prefix('/roles')->group(function () {
                // 角色列表
                Route::get('/', 'RoleController@getRoles');
                // 新增角色
                Route::post('/', 'RoleController@postRoles');
                // 修改角色名稱
                Route::patch('/{roleId}/name', 'RoleController@patchRolesName');
                // 指派權限
                Route::post('/{roleId}/permissions', 'RoleController@postPermissions');
                // 同步權限
                Route::put('/{roleId}/permissions', 'RoleController@putPermissions');
                // 取消權限(多筆)
                Route::post('/{roleId}/revoke-permissions', 'RoleController@postRevokePermissions');
                // 刪除角色
                Route::delete('/{roleId}', 'RoleController@deleteRoles');
            });

            // 權限管理
            Route::prefix('/permissions')->group(function () {
                // 權限列表
                Route::get('/', 'PermissionController@getPermissions');
                // 新增權限
                Route::post('/', 'PermissionController@postPermissions');
                // 修改權限名稱
                Route::patch('/{permissionId}/name', 'PermissionController@patchPermissionsName');
                // 指派角色
                Route::post('/{permissionId}/roles', 'PermissionController@postRoles');
                // 同步角色
                Route::put('/{permissionId}/roles', 'PermissionController@putRoles');
                // 取消角色(多筆)
                Route::post('/{permissionId}/remove-roles', 'PermissionController@postRemoveRoles');
                // 刪除權限
                Route::delete('/{permissionId}', 'PermissionController@deletePermissions');
            });
        });
    });
});
