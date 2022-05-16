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
          'name' => 'Ahuachapán',
        ],
        [
          'name' => 'Apaneca',
        ],
        [
          'name' => 'Atiquizaya',
        ],
        [
          'name' => 'Concepción de Ataco',
        ],
        [
          'name' => 'El Refugio',
        ],
        [
          'name' => 'Guaymango',
        ],
        [
          'name' => 'Jujutla',
        ],
        [
          'name' => 'San Francisco Menéndez',
        ],
        [
          'name' => 'San Lorenzo',
        ],
        [
          'name' => 'San Pedro Puxtla',
        ],
        [
          'name' => 'Tacuba',
        ],
        [
          'name' => 'Turín',
        ],
      ]
        ],
    [
      'id' => 2,
      'name' => 'Cabañas',
      'country_id' => 1,
      'municipalities' => [
        [
          'name' => 'Sensuntepeque',
        ],
        [
          'name' => 'Cinquera',
        ],
        [
          'name' => 'Dolores',
        ],
        [
          'name' => 'Guacotecti',
        ],
        [
          'name' => 'Ilobasco',
        ],
        [
          'name' => 'Jutiapa',
        ],
        [
          'name' => 'San Isidro',
        ],
        [
          'name' => 'Tejutepeque',
        ],
        [
          'name' => 'Victoria',
        ],
      ]
        ],
    [
      'id' => 3,
      'name' => 'Chalatenango',
      'country_id' => 1,
      'municipalities' => [
        [
          'name' => 'Chalatenango',
        ],
        [
          'name' => 'Agua Caliente',
        ],
        [
          'name' => 'Arcatao',
        ],
        [
          'name' => 'Citalá',
        ],
        [
          'name' => 'Comalapa',
        ],
        [
          'name' => 'Concepción Quezaltepeque',
        ],
        [
          'name' => 'Dulce Nombre de María',
        ],
        [
          'name' => 'El Carrizal',
        ],
        [
          'name' => 'El Paraíso',
        ],
        [
          'name' => 'La Laguna',
        ],
        [
          'name' => 'La Palma',
        ],
        [
          'name' => 'La Reina',
        ],
        [
          'name' => 'Las Vueltas',
        ],
        [
          'name' => 'Nombre de Jesús',
        ],
        [
          'name' => 'Nueva Concepción',
        ],
        [
          'name' => 'Nueva Trinidad',
        ],
        [
          'name' => 'Ojos de Agua',
        ],
        [
          'name' => 'Potonico',
        ],
        [
          'name' => 'San Antonio de La Cruz',
        ],
        [
          'name' => 'San Antonio Los Ranchos',
        ],
        [
          'name' => 'San Fernando',
        ],
        [
          'name' => 'San Francisco Lempa',
        ],
        [
          'name' => 'San Francisco Morazán',
        ],
        [
          'name' => 'San Ignacio',
        ],
        [
          'name' => 'San José Cancasque',
        ],
        [
          'name' => 'San José Las Flores',
        ],
        [
          'name' => 'San Luis del Carmen',
        ],
        [
          'name' => 'San Miguel de Mercedes',
        ],
        [
          'name' => 'San Rafael',
        ],
        [
          'name' => 'Santa Rita',
        ],
        [
          'name' => 'Tejutla',
        ],
      ]
        ],
    [
      'id' => 4,
      'name' => 'Cuscatlán',
      'country_id' => 1,
      'municipalities' => [
        [
          'name' => 'Cojutepeque',
        ],
        [
          'name' => 'Candelaria',
        ],
        [
          'name' => 'El Carmen',
        ],
        [
          'name' => 'El Rosario',
        ],
        [
          'name' => 'Monte San Juan',
        ],
        [
          'name' => 'Oratorio de Concepción',
        ],
        [
          'name' => 'San Bartolomé Perulapía',
        ],
        [
          'name' => 'San Cristóbal',
        ],
        [
          'name' => 'San José Guayabal',
        ],
        [
          'name' => 'San Pedro Perulapán',
        ],
        [
          'name' => 'San Rafael Cedros',
        ],
        [
          'name' => 'San Ramón',
        ],
        [
          'name' => 'Santa Cruz Analquito',
        ],
        [
          'name' => 'Santa Cruz Michapa',
        ],
        [
          'name' => 'Suchitoto',
        ],
        [
          'name' => 'Tenancingo',
        ],
      ]
        ],
    [
      'id' => 5,
      'name' => 'La Libertad',
      'country_id' => 1,
      'municipalities' => [
        [
          'name' => 'Santa Tecla',
        ],
        [
          'name' => 'Antiguo Cuscatlán',
        ],
        [
          'name' => 'Chiltiupán',
        ],
        [
          'name' => 'Ciudad Arce',
        ],
        [
          'name' => 'Colón',
        ],
        [
          'name' => 'Comasagua',
        ],
        [
          'name' => 'Huizúcar',
        ],
        [
          'name' => 'Jayaque',
        ],
        [
          'name' => 'Jicalapa',
        ],
        [
          'name' => 'Nuevo Cuscatlán',
        ],
        [
          'name' => 'Puerto de la Libertad',
        ],
        [
          'name' => 'Quezaltepeque',
        ],
        [
          'name' => 'Sacacoyo',
        ],
        [
          'name' => 'San José Villanueva',
        ],
        [
          'name' => 'San Juan Opico',
        ],
        [
          'name' => 'San Matías',
        ],
        [
          'name' => 'San Pablo Tacachico',
        ],
        [
          'name' => 'Talnique',
        ],
        [
          'name' => 'Tamanique',
        ],
        [
          'name' => 'Teotepeque',
        ],
        [
          'name' => 'Tepecoyo',
        ],
        [
          'name' => 'Zaragoza',
        ],
      ]
        ],
    [
      'id' => 6,
      'name' => 'La Paz',
      'country_id' => 1,
      'municipalities' => [
        [
          'name' => 'Zacatecoluca',
        ],
        [
          'name' => 'Cuyultitán',
        ],
        [
          'name' => 'El Rosario',
        ],
        [
          'name' => 'Jerusalén',
        ],
        [
          'name' => 'Mercedes La Ceiba',
        ],
        [
          'name' => 'Olocuilta',
        ],
        [
          'name' => 'Paraíso de Osorio',
        ],
        [
          'name' => 'San Antonio Masahuat',
        ],
        [
          'name' => 'San Emigdio',
        ],
        [
          'name' => 'San Francisco Chinameca',
        ],
        [
          'name' => 'San Juan Nonualco',
        ],
        [
          'name' => 'San Juan Talpa',
        ],
        [
          'name' => 'San Juan Tepezontes',
        ],
        [
          'name' => 'San Luis La Herradura',
        ],
        [
          'name' => 'San Luis Talpa',
        ],
        [
          'name' => 'San Miguel Tepezontes',
        ],
        [
          'name' => 'San Pedro Masahuat',
        ],
        [
          'name' => 'San Pedro Nonualco',
        ],
        [
          'name' => 'San Rafael Obrajuelo',
        ],
        [
          'name' => 'Santa María Ostuma',
        ],
        [
          'name' => 'Santiago Nonualco',
        ],
        [
          'name' => 'Tapalhauca',
        ],
      ]
        ],
    [
      'id' => 7,
      'name' => 'La Unión',
      'country_id' => 1,
      'municipalities' => [
        [
          'name' => 'La Unión',
        ],
        [
          'name' => 'Anamorós',
        ],
        [
          'name' => 'Bolívar',
        ],
        [
          'name' => 'Concepción de Oriente',
        ],
        [
          'name' => 'Conchagua',
        ],
        [
          'name' => 'El Carmen',
        ],
        [
          'name' => 'El Sauce',
        ],
        [
          'name' => 'Intipucá',
        ],
        [
          'name' => 'Lislique',
        ],
        [
          'name' => 'Meanguera del Golfo',
        ],
        [
          'name' => 'Nueva Esparta',
        ],
        [
          'name' => 'Pasaquina',
        ],
        [
          'name' => 'Polorós',
        ],
        [
          'name' => 'San Alejo',
        ],
        [
          'name' => 'San José La Fuente',
        ],
        [
          'name' => 'Santa Rosa de Lima',
        ],
        [
          'name' => 'Yayantique',
        ],
        [
          'name' => 'Yucuaiquín',
        ],
      ]
        ],
    [
      'id' => 8,
      'name' => 'Morazán',
      'country_id' => 1,
      'municipalities' => [
        [
          'name' => 'San Francisco Gotera',
        ],
        [
          'name' => 'Arambala',
        ],
        [
          'name' => 'Cacaopera',
        ],
        [
          'name' => 'Chilanga',
        ],
        [
          'name' => 'Corinto',
        ],
        [
          'name' => 'Delicias de Concepción',
        ],
        [
          'name' => 'El Divisadero',
        ],
        [
          'name' => 'El Rosario',
        ],
        [
          'name' => 'Gualococti',
        ],
        [
          'name' => 'Guatajiagua',
        ],
        [
          'name' => 'Joateca',
        ],
        [
          'name' => 'Jocoaitique',
        ],
        [
          'name' => 'Jocoro',
        ],
        [
          'name' => 'Lolotiquillo',
        ],
        [
          'name' => 'Meanguera',
        ],
        [
          'name' => 'Osicala',
        ],
        [
          'name' => 'Perquín',
        ],
        [
          'name' => 'San Carlos',
        ],
        [
          'name' => 'San Fernando',
        ],
        [
          'name' => 'San Isidro',
        ],
        [
          'name' => 'San Simón',
        ],
        [
          'name' => 'Sensembra',
        ],
        [
          'name' => 'Sociedad',
        ],
        [
          'name' => 'Torola',
        ],
        [
          'name' => 'Yamabal',
        ],
        [
          'name' => 'Yoloaiquín',
        ],
      ]
        ],
    [
      'id' => 9,
      'name' => 'San Miguel',
      'country_id' => 1,
      'municipalities' => [
        [
          'name' => 'San Miguel',
        ],
        [
          'name' => 'Carolina',
        ],
        [
          'name' => 'Chapeltique',
        ],
        [
          'name' => 'Chinameca',
        ],
        [
          'name' => 'Chirilagua',
        ],
        [
          'name' => 'Ciudad Barrios',
        ],
        [
          'name' => 'Comacarán',
        ],
        [
          'name' => 'El Tránsito',
        ],
        [
          'name' => 'Lolotique',
        ],
        [
          'name' => 'Moncagua',
        ],
        [
          'name' => 'Nueva Guadalupe',
        ],
        [
          'name' => 'Nuevo Edén de San Juan',
        ],
        [
          'name' => 'Quelepa',
        ],
        [
          'name' => 'San Antonio del Mosco',
        ],
        [
          'name' => 'San Gerardo',
        ],
        [
          'name' => 'San Jorge',
        ],
        [
          'name' => 'San Luis de La Reina',
        ],
        [
          'name' => 'Sesori',
        ],
        [
          'name' => 'Uluazapa',
        ],
      ]
        ],
    [
      'id' => 10,
      'name' => 'San Salvador',
      'country_id' => 1,
      'municipalities' => [
        [
          'name' => 'San Salvador',
        ],
        [
          'name' => 'Aguilares',
        ],
        [
          'name' => 'Apopa',
        ],
        [
          'name' => 'Ayutuxtepeque',
        ],
        [
          'name' => 'Ciudad Delgado',
        ],
        [
          'name' => 'Cuscatancingo',
        ],
        [
          'name' => 'El Paisnal',
        ],
        [
          'name' => 'Guazapa',
        ],
        [
          'name' => 'Ilopango',
        ],
        [
          'name' => 'Mejicanos',
        ],
        [
          'name' => 'Nejapa',
        ],
        [
          'name' => 'Panchimalco',
        ],
        [
          'name' => 'Rosario de Mora',
        ],
        [
          'name' => 'San Marcos',
        ],
        [
          'name' => 'San Martín',
        ],
        [
          'name' => 'Santiago Texacuangos',
        ],
        [
          'name' => 'Santo Tomás',
        ],
        [
          'name' => 'Soyapango',
        ],
        [
          'name' => 'Tonacatepeque',
        ],
      ]
        ],
    [
      'id' => 11,
      'name' => 'San Vicente',
      'country_id' => 1,
      'municipalities' => [
        [
          'name' => 'San Vicente',
        ],
        [
          'name' => 'Apastepeque',
        ],
        [
          'name' => 'Guadalupe',
        ],
        [
          'name' => 'San Cayetano Istepeque',
        ],
        [
          'name' => 'San Esteban Catarina',
        ],
        [
          'name' => 'San Ildefonso',
        ],
        [
          'name' => 'San Lorenzo',
        ],
        [
          'name' => 'San Sebastián',
        ],
        [
          'name' => 'Santa Clara',
        ],
        [
          'name' => 'Santo Domingo',
        ],
        [
          'name' => 'Tecoluca',
        ],
        [
          'name' => 'Tepetitán',
        ],
        [
          'name' => 'Verapaz',
        ],
      ]
        ],
    [
      'id' => 12,
      'name' => 'Santa Ana',
      'country_id' => 1,
      'municipalities' => [
        [
          'name' => 'Santa Ana',
        ],
        [
          'name' => 'Candelaria de la Frontera',
        ],
        [
          'name' => 'Chalchuapa',
        ],
        [
          'name' => 'Coatepeque',
        ],
        [
          'name' => 'El Congo',
        ],
        [
          'name' => 'El Porvenir',
        ],
        [
          'name' => 'Masahuat',
        ],
        [
          'name' => 'Metapán',
        ],
        [
          'name' => 'San Antonio Pajonal',
        ],
        [
          'name' => 'San Sebastián Salitrillo',
        ],
        [
          'name' => 'Santa Rosa Guachipilín',
        ],
        [
          'name' => 'Santiago de la Frontera',
        ],
        [
          'name' => 'Texistepeque',
        ],
      ]
        ],
    [
      'id' => 13,
      'name' => 'Sonsonate',
      'country_id' => 1,
      'municipalities' => [
        [
          'name' => 'Sonsonate',
        ],
        [
          'name' => 'Acajutla',
        ],
        [
          'name' => 'Armenia',
        ],
        [
          'name' => 'Caluco',
        ],
        [
          'name' => 'Cuisnahuat',
        ],
        [
          'name' => 'Izalco',
        ],
        [
          'name' => 'Juayúa',
        ],
        [
          'name' => 'Nahulingo',
        ],
        [
          'name' => 'Nahuizalco',
        ],
        [
          'name' => 'Salcoatitán',
        ],
        [
          'name' => 'San Antonio del Monte',
        ],
        [
          'name' => 'San Julián',
        ],
        [
          'name' => 'Santa Catarina Masahuat',
        ],
        [
          'name' => 'Santa Isabel Ishuatán',
        ],
        [
          'name' => 'Santo Domingo de Guzmán',
        ],
        [
          'name' => 'Sonzacate',
        ],
      ]
        ],
    [
      'id' => 14,
      'name' => 'Usulután',
      'country_id' => 1,
      'municipalities' => [
        [
          'name' => 'Usulután',
        ],
        [
          'name' => 'Alegría',
        ],
        [
          'name' => 'Berlín',
        ],
        [
          'name' => 'California',
        ],
        [
          'name' => 'Concepción Batres',
        ],
        [
          'name' => 'El Triunfo',
        ],
        [
          'name' => 'Ereguayquín',
        ],
        [
          'name' => 'Estanzuelas',
        ],
        [
          'name' => 'Jiquilisco',
        ],
        [
          'name' => 'Jucuapa',
        ],
        [
          'name' => 'Jucuarán',
        ],
        [
          'name' => 'Mercedes Umaña',
        ],
        [
          'name' => 'Nueva Granada',
        ],
        [
          'name' => 'Ozatlán',
        ],
        [
          'name' => 'Puerto El Triunfo',
        ],
        [
          'name' => 'San Agustín',
        ],
        [
          'name' => 'San Buenaventura',
        ],
        [
          'name' => 'San Dionisio',
        ],
        [
          'name' => 'San Francisco Javier',
        ],
        [
          'name' => 'Santa Elena',
        ],
        [
          'name' => 'Santa María',
        ],
        [
          'name' => 'Santiago de María',
        ],
        [
          'name' => 'Tecapán',
        ],
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
