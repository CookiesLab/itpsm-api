<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // Reset cached roles and permissions
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    // create permissions
    Permission::create(['name' => 'crear notas']);
    Permission::create(['name' => 'editar notas']);
    Permission::create(['name' => 'leer notas']);
    Permission::create(['name' => 'leer nota']);
    Permission::create(['name' => 'borrar notas']);

    Permission::create(['name' => 'crear estudiantes']);
    Permission::create(['name' => 'editar estudiantes']);
    Permission::create(['name' => 'leer estudiantes']);
    Permission::create(['name' => 'leer estudiante']);
    Permission::create(['name' => 'borrar estudiantes']);

    // create roles and assign created permissions

    Role::create(['name' => 'Administrador']);

    Role::create(['name' => 'Registro Académico'])
      ->givePermissionTo(['editar notas', 'leer notas', 'leer nota']);

    Role::create(['name' => 'Maestro'])
      ->givePermissionTo(['crear notas', 'editar notas', 'leer notas','leer nota']);

    Role::create(['name' => 'Estudiante'])
      ->givePermissionTo(['leer nota']);


  }
}
