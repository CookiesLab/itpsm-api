<?php

namespace App\Repositories\Roles;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class EloquentRoles implements RoleInterface
{

  public function createRole(string $name): Role|null
  {
    try {
      return Role::create(['name' => $name]);
    } catch (\Exception $e) {
      Log::channel('custom')->error($e->getMessage());
      return null;
    }
  }

  public function assignRoleTo(string $roleName, string $destination)
  {
    try {

    } catch (\Exception $e) {
      Log::channel('custom')->error($e->getMessage());
      return null;
    }
  }
}
