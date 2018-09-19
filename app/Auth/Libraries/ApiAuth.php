<?php

namespace App\Auth\Libraries;

use App\Auth\Contracts\ApiAuthContract;
use App\Auth\Repositories\UserRepository;
use Carbon\Carbon;
use Config;
use Exception;
use Firebase\JWT\JWT;
use Hash;
use Illuminate\Http\Request;
use Log;

class ApiAuth extends Guard implements ApiAuthContract
{
    protected $currentId = '';
    protected $request;
    protected $userRepository;

    public function __construct(Request $request, UserRepository $userRepository)
    {
        $this->request = $request;
        $this->userRepository = $userRepository;
    }

    public function createToken(string $username = ''): string
    {
        try {
            $user = $this->userRepository->findByUsername($username);
            $expiresAt = Config::get('auth.expiresAt');
            $algo = Config::get('auth.algo');
            $key = env('APP_KEY');

            $payload = [
                'iss' => 'Company',
                'jti' => $user->id,
                'sub' => $username,
                'iat' => Carbon::now()->timestamp,
                'exp' => Carbon::now()->addDay($expiresAt)->timestamp,
                'name' => $user->name,
                'roles' => $this->roles($user->id),
                'permissions' => $this->permissions($user->id),
            ];

            $token = JWT::encode($payload, $key, $algo);

            return $token;
        } catch (Exception $e) {
            Log::error($e);
            abort(500, 'Token generation failed.');
        }
    }

    public function verifyToken(string $token = null): bool
    {
        if ($token) {
            try {
                $algo = Config::get('auth.algo');
                $key = env('APP_KEY');
                $payload = JWT::decode($token, $key, [$algo]);
            } catch (Exception $e) {
                Log::error($e);
                abort(401, 'Token invalid or expired.');
            }

            if ($payload->jti) {
                $this->setCurrentId($payload->jti);

                return true;
            }
        }

        return false;
    }

    public function attempt(string $username = '', string $password = '')
    {
        [$username, $password] = $this->trimArray([$username, $password]);

        if (!$this->checkEmpty([$username, $password])) {
            return false;
        }

        // LDAP
        // $result = Adldap::auth()->attempt($username, $password);

        $user = $this->userRepository->findByUsername($username);

        return Hash::check($password, $user->secret);
    }

    public function login(string $username = '', string $password = ''): bool
    {
        if ($this->attempt($username, $password)) {
            $user = $this->userRepository->findByUsername($username);

            $this->setCurrentId($user->id);

            return true;
        }

        return false;
    }

    public function logout()
    {
        $this->currentId = null;
    }

    public function permissions(string $userId = ''): array
    {
        return $this->userRepository->getPermissions($userId)->all();
    }

    public function roles(string $userId = ''): array
    {
        return $this->userRepository->getRoles($userId)->all();
    }

    public function getCurrentId(): string
    {
        if ($this->currentId) {
            return $this->currentId;
        } else {
            $token = $this->request->bearerToken();

            $this->verifyToken($token);

            return $this->currentId;
        }
    }

    public function setCurrentId(string $currentId = '')
    {
        $this->currentId = $currentId;
    }
}
