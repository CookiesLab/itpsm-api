<?php

namespace App\Repositories\Roles;

use App\Repositories\RepositoryInterface;

interface RoleInterface
{
    public function createRole(string $name);
    public function assignRoleTo(string $roleName,string $destination);
}
