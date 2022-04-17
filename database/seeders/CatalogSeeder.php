<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Country;
use App\Models\Department;
use App\Models\Municipality;
use App\Models\Status;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
  private $departments = [
    [
      'id' => 1,
      'name' => 'Ahuachapán',
      'country_id' => 1,
      'municipalities' => [
        [
          'id' => 17,
          'name' => 'Atiquizaya',
        ]
      ]
        ],
    [
      'id' => 2,
      'name' => 'Cabañas',
      'country_id' => 1,
      'municipalities' => [
        [
          'id' => 14,
          'name' => 'Ahuachapán',
        ]
      ]
        ],
    [
      'id' => 3,
      'name' => 'Chalatenango',
      'country_id' => 1,
      'municipalities' => [
        [
          'id' => 13,
          'name' => 'Ahuachapán',
        ]
      ]
        ],
    [
      'id' => 4,
      'name' => 'Cuscatlán',
      'country_id' => 1,
      'municipalities' => [
        [
          'id' => 12,
          'name' => 'Ahuachapán',
        ]
      ]
        ],
    [
      'id' => 5,
      'name' => 'La Libertad',
      'country_id' => 1,
      'municipalities' => [
        [
          'id' => 11,
          'name' => 'Ahuachapán',
        ]
      ]
        ],
    [
      'id' => 6,
      'name' => 'La Paz',
      'country_id' => 1,
      'municipalities' => [
        [
          'id' => 10,
          'name' => 'Ahuachapán',
        ]
      ]
        ],
    [
      'id' => 7,
      'name' => 'La Unión',
      'country_id' => 1,
      'municipalities' => [
        [
          'id' => 9,
          'name' => 'Ahuachapán',
        ]
      ]
        ],
    [
      'id' => 8,
      'name' => 'Morazán',
      'country_id' => 1,
      'municipalities' => [
        [
          'id' => 8,
          'name' => 'Ahuachapán',
        ]
      ]
        ],
    [
      'id' => 9,
      'name' => 'San Miguel',
      'country_id' => 1,
      'municipalities' => [
        [
          'id' => 7,
          'name' => 'Ahuachapán',
        ]
      ]
        ],
    [
      'id' => 10,
      'name' => 'San Salvador',
      'country_id' => 1,
      'municipalities' => [
        [
          'id' => 6,
          'name' => 'Ahuachapán',
        ]
      ]
        ],
    [
      'id' => 11,
      'name' => 'San Vicente',
      'country_id' => 1,
      'municipalities' => [
        [
          'id' => 5,
          'name' => 'Ahuachapán',
        ]
      ]
        ],
    [
      'id' => 12,
      'name' => 'Santa Ana',
      'country_id' => 1,
      'municipalities' => [
        [
          'id' => 4,
          'name' => 'Ahuachapán',
        ]
      ]
        ],
    [
      'id' => 13,
      'name' => 'Sonsonate',
      'country_id' => 1,
      'municipalities' => [
        [
          'id' => 2,
          'name' => 'Ahuachapán',
        ]
      ]
        ],
    [
      'id' => 14,
      'name' => 'Usulután',
      'country_id' => 1,
      'municipalities' => [
        [
          'id' => 3,
          'name' => 'Apaneca',
        ]
      ]
        ],
  ];

  private $status = [
    [
      'id' => 1,
      'name' => 'Activo',
      'type' => 'A'
    ],
    [
      'id' => 2,
      'name' => 'Inactivo',
      'type' => 'B'
    ],
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
        'id' => $department['id'],
        'name' => $department['name'],
        'country_id' => $department['country_id'],
      ]);

      foreach ($department['municipalities'] as $municipality) {
        Municipality::create([
          'id' => $municipality['id'],
          'name' => $municipality['name'],
          'department_id' => $department['id'],
          'country_id' => $department['country_id'],
        ]);
      }
    }

    foreach ($this->status as $statu) {
      Status::create([
        'id' => $statu['id'],
        'name' => $statu['name'],
        'type' => $statu['type'],
      ]);
    }

    /*foreach ($this->municipalities as &$municipality) {
      Municipality::create([
        'name' => $municipality,
        'department_id' => 1,
        'country_id' => 1,
      ]);
    }*/
  }
}
