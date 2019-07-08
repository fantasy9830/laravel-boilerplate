<?php

namespace App\Http\Controllers;

use Auth;
use App\Exceptions\ErrorException;
use App\Exceptions\UnauthorizedTokenException;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function postToken()
    {
        $grantType = request('grant_type');

        // 驗證 OAuth 2.0 授權類型
        if (empty($grantType)) {
            throw new ErrorException(400, 'invalid_request', 'Missing grant type');

        } elseif ($grantType === 'password') {
            $credentials = request(['username','password']);

            // 驗證是否有缺少參數
            if (!isset($credentials['username'])) {
                throw new ErrorException(400, 'invalid_request', "Request was missing the 'username' parameter");
            }

            if (!isset($credentials['password'])) {
                throw new ErrorException(400, 'invalid_request', "Request was missing the 'password' parameter");
            }

            // 登入驗證
            if ($token = Auth::attempt($credentials)) {
                // Passed!
                return $this->respondWithToken($token);
            } else {
                throw new ErrorException(401, 'invalid_client', 'Client Authentication failed');
            }
        } elseif ($grantType === 'refresh_token') {
            $refreshToken = request('refresh_token');

            // 驗證是否有缺少參數
            if (empty($refreshToken)) {
                throw new ErrorException(400, 'invalid_request', "Request was missing the 'refresh_token' parameter");
            }

            try {
                $token = Auth::setToken($refreshToken)->refresh();
            } catch (JWTException $exception) {
                throw new UnauthorizedTokenException($exception->getMessage());
            }

            return $this->respondWithToken($token, $refreshToken);
        } else {
            throw new ErrorException(400, 'unsupported_grant_type', "Unsupported grant type: '{$grantType}'");
        }
    }

    public function postRegister()
    {
        // register
    }

    protected function respondWithToken(string $token, string $refreshToken = null)
    {
        $response = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => config('jwt.ttl') * 60,
            'scope' => config('app.url'),
        ];

        if ($refreshToken) {
            $response = array_merge($response, [
                'refresh_token' => $refreshToken,
            ]);
        }

        return response($response)
            ->withHeaders([
                'Cache-Control' =>'no-store',
                'Pragma' => 'no-cache',
            ]);
    }
}
