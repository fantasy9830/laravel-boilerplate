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
    // TODO: 檢查username是否已經存在
    // Route::get('/user/id', 'AuthController@getUserId');
    Route::post('/register', 'AuthController@postRegister')->name('register');

    // TODO: 認證信 和 忘記密碼 功能

    //email verification
    // Route::post('/email/verify/{id}', 'AuthController@postVerification')->name('verification.verify')->middleware('signed');

    // reset password
    // Route::post('/password/email', 'AuthController@postPasswordEmail')->name('password.email');
    // Route::post('/password/reset', 'AuthController@postPasswordReset')->name('password.update');

    // 檢查JWT Token
    Route::middleware('auth.token')->group(function () {
        Route::prefix('/user')->group(function () {
            Route::get('/profile', 'PersonalController@getProfile');
        });

        Route::middleware('role:admin')->namespace('Admin')->group(function () {
            Route::prefix('/users')->group(function () {
                Route::get('/', 'UserController@getUsers');
                Route::post('/', 'UserController@postUsers');
                Route::put('/{id}/roles', 'UserController@putRoles');
                Route::put('/{id}/permissions', 'UserController@putPermissions');
                Route::delete('/{id}', 'UserController@deleteUsers');

                // TODO: 更改 user
                // Route::patch('/{id}', 'UserController@patchUser');

                // TODO: 重發認證信
                // Route::post('/{id}/verify/email', 'UserController@postVerifyEmail');
            });

            Route::prefix('/roles')->group(function () {
                Route::get('/', 'RoleController@getRoles');
                Route::post('/', 'RoleController@postRoles');
                Route::put('/{id}/users', 'RoleController@putUsers');
                Route::put('/{id}/permissions', 'RoleController@putPermissions');
                Route::patch('/{id}', 'RoleController@patchRoles');
                Route::delete('/{id}', 'RoleController@deleteRoles');
            });

            Route::prefix('/permissions')->group(function () {
                Route::get('/', 'PermissionController@getPermissions');
                Route::post('/', 'PermissionController@postPermissions');
                Route::put('/{id}/users', 'PermissionController@putUsers');
                Route::put('/{id}/roles', 'PermissionController@putRoles');
                Route::patch('/{id}', 'PermissionController@patchPermissions');
                Route::delete('/{id}', 'PermissionController@deletePermissions');
            });
        });
    });
});
