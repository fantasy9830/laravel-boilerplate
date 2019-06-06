<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function postToken()
    {
        $grantType = request('grant_type');
        $credentials = request(['username','password']);

        // 驗證 OAuth 2.0 授權類型
        if ($grantType !== 'password') {
            return response([
                    'error' => 'unsupported_grant_type',
                    'error_description' => '授權類型無法識別，本伺服器僅支持 Password 類型！'
                ], 400)
                ->withHeaders([
                    'Cache-Control' =>'no-store',
                    'Pragma' => 'no-cache',
                ]);
        }

        // 驗證是否有缺少參數
        if (!isset($credentials['username']) || !isset($credentials['password'])) {
            return response([
                    'error' => 'invalid_request',
                    'error_description' => '缺少參數！'
                ], 400)
                ->withHeaders([
                    'Cache-Control' =>'no-store',
                    'Pragma' => 'no-cache',
                ]);
        }

        // 登入驗證
        if ($token = Auth::attempt($credentials)) {
            // Passed!
            return response([
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => config('jwt.ttl'),
                    'scope' => config('app.url'),
                ])
                ->withHeaders([
                    'Cache-Control' =>'no-store',
                    'Pragma' => 'no-cache',
                ]);
        } else {
            return response([
                    'error' => 'invalid_client',
                    'error_description' => '登入驗證失敗！'
                ], 401)
                ->withHeaders([
                    'Cache-Control' =>'no-store',
                    'Pragma' => 'no-cache',
                ]);
        }
    }

    public function postRegister()
    {
        // register
    }
}
