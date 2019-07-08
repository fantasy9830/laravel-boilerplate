<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Exceptions\UnauthorizedTokenException;

class AuthController extends Controller
{
    public function postToken()
    {
        $grantType = request('grant_type');

        // 驗證 OAuth 2.0 授權類型
        if (empty($grantType)) {
            return $this->respondWithError('invalid_request', 'Missing grant type', 400);
        } elseif ($grantType === 'password') {
            $credentials = request(['username','password']);

            // 驗證是否有缺少參數
            if (!isset($credentials['username'])) {
                return $this->respondWithError('invalid_request', "Request was missing the 'username' parameter", 400);
            }

            if (!isset($credentials['password'])) {
                return $this->respondWithError('invalid_request', "Request was missing the 'password' parameter", 400);
            }

            // 登入驗證
            if ($token = Auth::attempt($credentials)) {
                // Passed!
                return $this->respondWithToken($token);
            } else {
                return $this->respondWithError('invalid_client', 'Client Authentication failed', 401);
            }
        } elseif ($grantType === 'refresh_token') {
            $refreshToken = request('refresh_token');

            // 驗證是否有缺少參數
            if (empty($refreshToken)) {
                return $this->respondWithError('invalid_request', "Request was missing the 'refresh_token' parameter", 400);
            }

            try {
                $token = Auth::setToken($refreshToken)->refresh();
            } catch (JWTException $exception) {
                throw new UnauthorizedTokenException($exception->getMessage());
            }

            return $this->respondWithToken($token, $refreshToken);
        } else {
            return $this->respondWithError('unsupported_grant_type', "Unsupported grant type: '{$grantType}'", 400);
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

    protected function respondWithError(string $error, string $description, int $code)
    {
        return response([
                'error' => $error,
                'error_description' => $description
            ], $code)
            ->withHeaders([
                'Cache-Control' =>'no-store',
                'Pragma' => 'no-cache',
            ]);
    }
}
