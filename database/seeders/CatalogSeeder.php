<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Country;
use App\Models\Department;
use App\Models\Municipality;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
  private $departments = [
    'San Miguel',
    'Usulutan',
    'Morazan',
    'La Unión',
  ];

  private $municipalities = [
    'San Miguel',
  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Country::create([
      'id' => 1,
      'name' => 'El Salvador',
    ]);

    foreach ($this->departments as &$department) {
      Department::create([
        'name' => $department,
        'country_id' => 1,
      ]);
    }

    foreach ($this->municipalities as &$municipality) {
      Municipality::create([
        'name' => $municipality,
        'department_id' => 1,
        'country_id' => 1,
      ]);
    }
  }
}
