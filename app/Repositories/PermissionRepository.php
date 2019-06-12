<?php

namespace App\Repositories;

use App\Models\Permission;
use Prettus\Repository\Eloquent\BaseRepository;

class PermissionRepository extends BaseRepository
{
    public function model(): string
    {
        return Permission::class;
    }
}
