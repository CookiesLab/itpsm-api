<?php

namespace App\Services\Roles;

use App\Repositories\Roles\RoleInterface;

class RoleManager
{
  protected RoleInterface $Role;

  /**
   * @param RoleInterface $Role
   */
  public function __construct(RoleInterface $Role)
  {
    $this->Role = $Role;
  }

  public function create(string $name): array
  {
    $result = $this->Role->createRole($name);
    if ($result != null)
      return [
        'success' => true,
        'role' => $result
      ];
    else
      return [
        'success' => false,
        'message' => 'Something went wrong'
      ];

  }


}
