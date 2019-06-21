<?php

namespace App\Services;

use App\Repositories\UserRepository;

class PersonalService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getProfile(int $userId)
    {
        $user = $this->userRepository->find($userId);

        return collect($user)->merge([
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()
                ->groupBy('guard_name')
                ->flatMap(function ($item) {
                    return $item->pluck('name');
                })
                ->reduce(function ($carry, $permission) {
                    [$action, $name] = explode('_', $permission);
                    $carry[$name][] = $action;

                    return $carry;
                }, []),
        ]);
    }
}
