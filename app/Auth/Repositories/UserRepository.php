<?php

namespace App\Auth\Repositories;

use App\Auth\Models\User;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    public function model(): string
    {
        return User::class;
    }

    public function findByUsername(string $username)
    {
        return $this->model->where('username', $username)->first();
    }

    public function getPermissions(int $userId)
    {
        return $this->find($userId)
            ->getAllPermissions()
            ->groupBy('action')
            ->map(function ($item) {
                return $item->pluck('name');
            });
    }

    public function getRoles(int $userId)
    {
        return $this->find($userId)->getRoleNames();
    }
}
