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
          'id' => 1,
          'name' => 'Ahuachapán',
        ],
        [
          'id' => 2,
          'name' => 'Apaneca',
        ],
        [
          'id' => 3,
          'name' => 'Atiquizaya',
        ],
        [ 'id' => 4,
          'name' => 'Concepción de Ataco',
        ],
        [
          'id' => 5,
          'name' => 'El Refugio',
        ],
        [
          'id' => 6,
          'name' => 'Guaymango',
        ],
        [
          'id' => 7,
          'name' => 'Jujutla',
        ],
        [
          'id' => 8,
          'name' => 'San Francisco Menéndez',
        ],
        [
          'id' => 9,
          'name' => 'San Lorenzo',
        ],
        [
          'id' => 10,
          'name' => 'San Pedro Puxtla',
        ],
        [
          'id' => 11,
          'name' => 'Tacuba',
        ],
        [
          'id' => 12,
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
          'id' => 13,
          'name' => 'Sensuntepeque',
        ],
        [
          'id' => 14,
          'name' => 'Cinquera',
        ],
        [
          'id' => 15,
          'name' => 'Dolores',
        ],
        [
          'id' => 16,
          'name' => 'Guacotecti',
        ],
        [
          'id' => 17,
          'name' => 'Ilobasco',
        ],
        [
          'id' => 18,
          'name' => 'Jutiapa',
        ],
        [
          'id' => 19,
          'name' => 'San Isidro',
        ],
        [
          'id' => 20,
          'name' => 'Tejutepeque',
        ],
        [
          'id' => 21,
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
          'id' => 22,
          'name' => 'Chalatenango',
        ],
        [
          'id' => 23,
          'name' => 'Agua Caliente',
        ],
        [
          'id' => 24,
          'name' => 'Arcatao',
        ],
        [
          'id' => 25,
          'name' => 'Citalá',
        ],
        ['id' => 26,
          'name' => 'Comalapa',
        ],
        [
          'id' => 27,
          'name' => 'Concepción Quezaltepeque',
        ],
        [
          'id' => 28,
          'name' => 'Dulce Nombre de María',
        ],
        [
          'id' => 29,
          'name' => 'El Carrizal',
        ],
        [
          'id' => 30,
          'name' => 'El Paraíso',
        ],
        [
          'id' => 31,
          'name' => 'La Laguna',
        ],
        [
          'id' => 32,
          'name' => 'La Palma',
        ],
        [
          'id' => 33,
          'name' => 'La Reina',
        ],
        [
          'id' => 34,
          'name' => 'Las Vueltas',
        ],
        [
          'id' => 35,
          'name' => 'Nombre de Jesús',
        ],
        [
          'id' => 36,
          'name' => 'Nueva Concepción',
        ],
        [
          'id' => 37,
          'name' => 'Nueva Trinidad',
        ],
        [
          'id' => 38,
          'name' => 'Ojos de Agua',
        ],
        [
          'id' => 39,
          'name' => 'Potonico',
        ],
        [
          'id' => 40,
          'name' => 'San Antonio de La Cruz',
        ],
        [
          'id' => 41,
          'name' => 'San Antonio Los Ranchos',
        ],
        [
          'id' => 42,
          'name' => 'San Fernando',
        ],
        [
          'id' => 43,
          'name' => 'San Francisco Lempa',
        ],
        [
          'id' => 44,
          'name' => 'San Francisco Morazán',
        ],
        [
          'id' => 45,
          'name' => 'San Ignacio',
        ],
        [
          'id' => 46,
          'name' => 'San José Cancasque',
        ],
        [
          'id' => 47,
          'name' => 'San José Las Flores',
        ],
        [
          'id' => 48,
          'name' => 'San Luis del Carmen',
        ],
        [
          'id' => 49,
          'name' => 'San Miguel de Mercedes',
        ],
        ['id' => 50,
          'name' => 'San Rafael',
        ],
        [
          'id' => 51,
          'name' => 'Santa Rita',
        ],
        [
          'id' => 52,
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
          'id' => 53,
          'name' => 'Cojutepeque',
        ],
        [
          'id' => 54,
          'name' => 'Candelaria',
        ],
        [
          'id' => 55,
          'name' => 'El Carmen',
        ],
        ['id' => 56,
          'name' => 'El Rosario',
        ],
        [
          'id' => 57,
          'name' => 'Monte San Juan',
        ],
        [
          'id' => 58,
          'name' => 'Oratorio de Concepción',
        ],
        [
          'id' => 59,
          'name' => 'San Bartolomé Perulapía',
        ],
        [
          'id' => 60,
          'name' => 'San Cristóbal',
        ],
        [
          'id' => 61,
          'name' => 'San José Guayabal',
        ],
        [
          'id' => 62,
          'name' => 'San Pedro Perulapán',
        ],
        [
          'id' => 63,
          'name' => 'San Rafael Cedros',
        ],
        [
          'id' => 64,
          'name' => 'San Ramón',
        ],
        [
          'id' => 65,
          'name' => 'Santa Cruz Analquito',
        ],
        [
          'id' => 66,
          'name' => 'Santa Cruz Michapa',
        ],
        [
          'id' => 67,
          'name' => 'Suchitoto',
        ],
        [
          'id' => 68,
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
          'id' => 69,
          'name' => 'Santa Tecla',
        ],
        [
          'id' => 70,
          'name' => 'Antiguo Cuscatlán',
        ],
        [
          'id' => 71,
          'name' => 'Chiltiupán',
        ],
        [
          'id' => 72,
          'name' => 'Ciudad Arce',
        ],
        [
          'id' => 73,
          'name' => 'Colón',
        ],
        ['id' => 74,
          'name' => 'Comasagua',
        ],
        [
          'id' => 75,
          'name' => 'Huizúcar',
        ],
        [
          'id' => 76,
          'name' => 'Jayaque',
        ],
        [
          'id' => 77,
          'name' => 'Jicalapa',
        ],
        [
          'id' => 78,
          'name' => 'Nuevo Cuscatlán',
        ],
        [
          'id' => 79,
          'name' => 'Puerto de la Libertad',
        ],
        [
          'id' => 80,
          'name' => 'Quezaltepeque',
        ],
        [
          'id' => 81,
          'name' => 'Sacacoyo',
        ],
        [
          'id' => 82,
          'name' => 'San José Villanueva',
        ],
        [
          'id' => 83,
          'name' => 'San Juan Opico',
        ],
        [
          'id' => 84,
          'name' => 'San Matías',
        ],
        [
          'id' => 85,
          'name' => 'San Pablo Tacachico',
        ],
        [
          'id' => 86,
          'name' => 'Talnique',
        ],
        [
          'id' => 87,
          'name' => 'Tamanique',
        ],
        [
          'id' => 88,
          'name' => 'Teotepeque',
        ],
        [
          'id' => 89,
          'name' => 'Tepecoyo',
        ],
        [
          'id' => 90,
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
          'id' => 91,
          'name' => 'Zacatecoluca',
        ],
        [
          'id' => 92,
          'name' => 'Cuyultitán',
        ],
        [
          'id' => 93,
          'name' => 'El Rosario',
        ],
        [
          'id' => 94,
          'name' => 'Jerusalén',
        ],
        [
          'id' => 95,
          'name' => 'Mercedes La Ceiba',
        ],
        [
          'id' => 96,
          'name' => 'Olocuilta',
        ],
        [
          'id' => 97,
          'name' => 'Paraíso de Osorio',
        ],
        [
          'id' => 98,
          'name' => 'San Antonio Masahuat',
        ],
        [
          'id' => 99,
          'name' => 'San Emigdio',
        ],
        [
          'id' => 100,
          'name' => 'San Francisco Chinameca',
        ],
        [
          'id' => 101,
          'name' => 'San Juan Nonualco',
        ],
        [
          'id' => 102,
          'name' => 'San Juan Talpa',
        ],
        [
          'id' => 103,
          'name' => 'San Juan Tepezontes',
        ],
        [
          'id' => 104,
          'name' => 'San Luis La Herradura',
        ],
        [
          'id' => 105,
          'name' => 'San Luis Talpa',
        ],
        [
          'id' => 106,
          'name' => 'San Miguel Tepezontes',
        ],
        [
          'id' => 107,
          'name' => 'San Pedro Masahuat',
        ],
        [
          'id' => 108,
          'name' => 'San Pedro Nonualco',
        ],
        [
          'id' => 109,
          'name' => 'San Rafael Obrajuelo',
        ],
        [
          'id' => 110,
          'name' => 'Santa María Ostuma',
        ],
        [
          'id' => 111,
          'name' => 'Santiago Nonualco',
        ],
        [
          'id' => 112,
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
          'id' => 113,
          'name' => 'La Unión',
        ],
        [
          'id' => 114,
          'name' => 'Anamorós',
        ],
        [
          'id' => 115,
          'name' => 'Bolívar',
        ],
        [
          'id' => 116,
          'name' => 'Concepción de Oriente',
        ],
        [
          'id' => 117,
          'name' => 'Conchagua',
        ],
        [
          'id' => 118,
          'name' => 'El Carmen',
        ],
        [
          'id' => 119,
          'name' => 'El Sauce',
        ],
        [
          'id' => 120,
          'name' => 'Intipucá',
        ],
        [
          'id' => 121,
          'name' => 'Lislique',
        ],
        [
          'id' => 122,
          'name' => 'Meanguera del Golfo',
        ],
        [
          'id' => 123,
          'name' => 'Nueva Esparta',
        ],
        [
          'id' => 124,
          'name' => 'Pasaquina',
        ],
        [
          'id' => 125,
          'name' => 'Polorós',
        ],
        [
          'id' => 126,
          'name' => 'San Alejo',
        ],
        ['id' => 127,
          'name' => 'San José La Fuente',
        ],
        ['id' => 128,
          'name' => 'Santa Rosa de Lima',
        ],
        ['id' => 129,
          'name' => 'Yayantique',
        ],
        ['id' => 130,
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
          'id' => 131,
          'name' => 'San Francisco Gotera',
        ],
        [
          'id' => 132,
          'name' => 'Arambala',
        ],
        [
          'id' => 133,
          'name' => 'Cacaopera',
        ],
        [
          'id' => 134,
          'name' => 'Chilanga',
        ],
        [
          'id' => 135,
          'name' => 'Corinto',
        ],
        [
          'id' => 136,
          'name' => 'Delicias de Concepción',
        ],
        [
          'id' => 137,
          'name' => 'El Divisadero',
        ],
        [
          'id' => 138,
          'name' => 'El Rosario',
        ],
        [
          'id' => 139,
          'name' => 'Gualococti',
        ],
        [
          'id' => 140,
          'name' => 'Guatajiagua',
        ],
        [
          'id' => 141,
          'name' => 'Joateca',
        ],
        [
          'id' => 142,
          'name' => 'Jocoaitique',
        ],
        [
          'id' => 143,
          'name' => 'Jocoro',
        ],
        [
          'id' => 144,
          'name' => 'Lolotiquillo',
        ],
        [
          'id' => 145,
          'name' => 'Meanguera',
        ],
        [
          'id' => 146,
          'name' => 'Osicala',
        ],
        [
          'id' => 147,
          'name' => 'Perquín',
        ],
        [
          'id' => 148,
          'name' => 'San Carlos',
        ],
        [
          'id' => 149,
          'name' => 'San Fernando',
        ],
        ['id' => 150,
          'name' => 'San Isidro',
        ],
        [
          'id' => 151,
          'name' => 'San Simón',
        ],
        [
          'id' => 152,
          'name' => 'Sensembra',
        ],
        [
          'id' => 153,
          'name' => 'Sociedad',
        ],
        [
          'id' => 154,
          'name' => 'Torola',
        ],
        [
          'id' => 155,
          'name' => 'Yamabal',
        ],
        [
          'id' => 156,
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
          'id' => 157,
          'name' => 'San Miguel',
        ],
        [
          'id' => 158,
          'name' => 'Carolina',
        ],
        [
          'id' => 159,
          'name' => 'Chapeltique',
        ],
        [
          'id' => 160,
          'name' => 'Chinameca',
        ],
        [
          'id' => 161,
          'name' => 'Chirilagua',
        ],
        [
          'id' => 162,
          'name' => 'Ciudad Barrios',
        ],
        [
          'id' => 163,
          'name' => 'Comacarán',
        ],
        [
          'id' => 164,
          'name' => 'El Tránsito',
        ],
        [
          'id' => 165,
          'name' => 'Lolotique',
        ],
        [
          'id' => 166,
          'name' => 'Moncagua',
        ],
        [
          'id' => 167,
          'name' => 'Nueva Guadalupe',
        ],
        [
          'id' => 168,
          'name' => 'Nuevo Edén de San Juan',
        ],
        [
          'id' => 169,
          'name' => 'Quelepa',
        ],
        [
          'id' => 170,
          'name' => 'San Antonio del Mosco',
        ],
        [
          'id' => 171,
          'name' => 'San Gerardo',
        ],
        [
          'id' => 172,
          'name' => 'San Jorge',
        ],
        [
          'id' => 173,
          'name' => 'San Luis de La Reina',
        ],
        [
          'id' => 174,
          'name' => 'Sesori',
        ],
        [
          'id' => 175,
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
          'id' => 176,
          'name' => 'San Salvador',
        ],
        [
          'id' => 177,
          'name' => 'Aguilares',
        ],
        [
          'id' => 178,
          'name' => 'Apopa',
        ],
        [
          'id' => 179,
          'name' => 'Ayutuxtepeque',
        ],
        [
          'id' => 180,
          'name' => 'Ciudad Delgado',
        ],
        [
          'id' => 181,
          'name' => 'Cuscatancingo',
        ],
        [
          'id' => 182,
          'name' => 'El Paisnal',
        ],
        [
          'id' => 183,
          'name' => 'Guazapa',
        ],
        [
          'id' => 184,
          'name' => 'Ilopango',
        ],
        [
          'id' => 185,
          'name' => 'Mejicanos',
        ],
        [
          'id' => 186,
          'name' => 'Nejapa',
        ],
        [
          'id' => 187,
          'name' => 'Panchimalco',
        ],
        [
          'id' => 188,
          'name' => 'Rosario de Mora',
        ],
        [
          'id' => 189,
          'name' => 'San Marcos',
        ],
        [
          'id' => 190,
          'name' => 'San Martín',
        ],
        [
          'id' => 191,
          'name' => 'Santiago Texacuangos',
        ],
        [
          'id' => 192,
          'name' => 'Santo Tomás',
        ],
        [
          'id' => 193,
          'name' => 'Soyapango',
        ],
        [
          'id' => 194,
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
          'id' => 195,
          'name' => 'San Vicente',
        ],
        [
          'id' => 196,
          'name' => 'Apastepeque',
        ],
        [
          'id' => 197,
          'name' => 'Guadalupe',
        ],
        [
          'id' => 198,
          'name' => 'San Cayetano Istepeque',
        ],
        [
          'id' => 199,
          'name' => 'San Esteban Catarina',
        ],
        [
          'id' => 200,
          'name' => 'San Ildefonso',
        ],
        [
          'id' => 201,
          'name' => 'San Lorenzo',
        ],
        [
          'id' => 202,
          'name' => 'San Sebastián',
        ],
        [
          'id' => 203,
          'name' => 'Santa Clara',
        ],
        [
          'id' => 204,
          'name' => 'Santo Domingo',
        ],
        [
          'id' => 205,
          'name' => 'Tecoluca',
        ],
        [
          'id' => 206,
          'name' => 'Tepetitán',
        ],
        [
          'id' => 207,
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
          'id' => 208,
          'name' => 'Santa Ana',
        ],
        [
          'id' => 209,
          'name' => 'Candelaria de la Frontera',
        ],
        [
          'id' => 210,
          'name' => 'Chalchuapa',
        ],
        [
          'id' => 211,
          'name' => 'Coatepeque',
        ],
        [
          'id' => 212,
          'name' => 'El Congo',
        ],
        [
          'id' => 213,
          'name' => 'El Porvenir',
        ],
        [
          'id' => 214,
          'name' => 'Masahuat',
        ],
        [
          'id' => 215,
          'name' => 'Metapán',
        ],
        [
          'id' => 216,
          'name' => 'San Antonio Pajonal',
        ],
        [
          'id' => 217,
          'name' => 'San Sebastián Salitrillo',
        ],
        [
          'id' => 218,
          'name' => 'Santa Rosa Guachipilín',
        ],
        [
          'id' => 219,
          'name' => 'Santiago de la Frontera',
        ],
        [
          'id' => 220,
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
          'id' => 221,
          'name' => 'Sonsonate',
        ],
        [
          'id' => 222,
          'name' => 'Acajutla',
        ],
        ['id' => 223,
          'name' => 'Armenia',
        ],
        [
          'id' => 224,
          'name' => 'Caluco',
        ],
        [
          'id' => 225,
          'name' => 'Cuisnahuat',
        ],
        [
          'id' => 226,
          'name' => 'Izalco',
        ],
        ['id' => 227,
          'name' => 'Juayúa',
        ],
        [
          'id' => 228,
          'name' => 'Nahulingo',
        ],
        [
          'id' => 229,
          'name' => 'Nahuizalco',
        ],
        [
          'id' => 230,
          'name' => 'Salcoatitán',
        ],
        [
          'id' => 231,
          'name' => 'San Antonio del Monte',
        ],
        [
          'id' => 232,
          'name' => 'San Julián',
        ],
        [
          'id' => 233,
          'name' => 'Santa Catarina Masahuat',
        ],
        [
          'id' => 234,
          'name' => 'Santa Isabel Ishuatán',
        ],
        [
          'id' => 235,
          'name' => 'Santo Domingo de Guzmán',
        ],
        [
          'id' => 236,
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
          'id' => 237,
          'name' => 'Usulután',
        ],
        [
          'id' => 238,
          'name' => 'Alegría',
        ],
        [
          'id' => 239,
          'name' => 'Berlín',
        ],
        [
          'id' => 240,
          'name' => 'California',
        ],
        [
          'id' => 241,
          'name' => 'Concepción Batres',
        ],
        [
          'id' => 242,
          'name' => 'El Triunfo',
        ],
        [
          'id' => 243,
          'name' => 'Ereguayquín',
        ],
        [
          'id' => 244,
          'name' => 'Estanzuelas',
        ],
        [
          'id' => 245,
          'name' => 'Jiquilisco',
        ],
        [
          'id' => 246,
          'name' => 'Jucuapa',
        ],
        [
          'id' => 247,
          'name' => 'Jucuarán',
        ],
        [
          'id' => 248,
          'name' => 'Mercedes Umaña',
        ],
        [
          'id' => 249,
          'name' => 'Nueva Granada',
        ],
        [
          'id' => 250,
          'name' => 'Ozatlán',
        ],
        [
          'id' => 251,
          'name' => 'Puerto El Triunfo',
        ],
        [
          'id' => 252,
          'name' => 'San Agustín',
        ],
        [
          'id' => 253,
          'name' => 'San Buenaventura',
        ],
        ['id' => 254,
          'name' => 'San Dionisio',
        ],
        [
          'id' => 255,
          'name' => 'San Francisco Javier',
        ],
        [
          'id' => 256,
          'name' => 'Santa Elena',
        ],
        [
          'id' => 257,
          'name' => 'Santa María',
        ],
        ['id' => 258,
          'name' => 'Santiago de María',
        ],
        ['id' => 259,
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
