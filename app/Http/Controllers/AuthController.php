<?php

namespace App\Http\Controllers;

use Auth;
use App\Exceptions\ErrorException;
use App\Exceptions\UnauthorizedTokenException;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/auth/token",
     *      tags={"Auth"},
     *      summary="用戶登入",
     *      description="登入並取得 JWT",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  required={"grant_type"},
     *                  @OA\Property(
     *                      property="grant_type",
     *                      description="OAuth 2.0 授權類型 password or refresh_token",
     *                      type="string",
     *                      enum={"password", "refresh_token"}
     *                  ),
     *                  @OA\Property(
     *                      property="username",
     *                      description="帳號",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      description="密碼",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="refresh_token",
     *                      description="舊的 access token",
     *                      type="string",
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="登入成功"),
     *      @OA\Response(
     *          response="default",
     *          description="unexpected error",
     *          @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      ),
     * )
     */
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

    /**
     * @OA\Post(
     *      path="/register",
     *      tags={"Auth"},
     *      summary="註冊",
     *      description="註冊新的帳號",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                   required={"username", "email", "password", "password_confirmation", "name", "nickname", "gender"},
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
     *                   @OA\Property(
     *                       property="password",
     *                       description="密碼",
     *                       type="string",
     *                   ),
     *                  @OA\Property(
     *                      property="password_confirmation",
     *                      description="密碼驗證",
     *                      type="string",
     *                  ),
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
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="註冊成功"),
     *      @OA\Response(
     *          response="default",
     *          description="unexpected error",
     *          @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      ),
     * )
     */
    public function postRegister(Request $request)
    {
        try {
            $credentials = $request->validate([
                'username' => 'required',
                'email' => 'required',
                'password' => 'required|confirmed',
                'name' => 'required',
                'nickname' => 'required',
                'gender' => 'required',
            ]);
        } catch (ValidationException $e) {
            throw new ErrorException(400, 'invalid_request', $e->getMessage());
        }

        return $credentials;
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
