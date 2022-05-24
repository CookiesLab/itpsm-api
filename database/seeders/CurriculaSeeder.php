<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Career;
use App\Models\Curriculum;
use App\Models\Subject;
use App\Models\CurriculumSubject;
use App\Models\Prerequisite;
use App\Models\StudentCurriculum;
use App\Models\Scholarship;
use App\Models\Student;

class CurriculaSeeder extends Seeder
{
  private $careers = [
    [
      'id' => 1,
      'name' => 'Técnico en Ingeniería de Construcción',
    ],
    [
      'id' => 2,
      'name' => 'Técnico Superior en Hostelería y Turismo',
    ],
  ];

  private $subjects = [
    [
      'id' => 1,
      'name' => 'Propiedades de los Agregados Pétreos y Cementos Hidráulicos',
      'code' => '100042',
    ],
    [
      'id' => 2,
      'name' => 'Inglés técnico',
      'code' => '100043',
    ],
    [
      'id' => 3,
      'name' => 'Legislación Normativa y Trámites Legales',
      'code' => '100044',
    ],
    [
      'id' => 4,
      'name' => 'Levantamientos Topográficos Planimétricos',
      'code' => '100045',
    ],
    [
      'id' => 5,
      'name' => 'Levantamientos Topográficos Altimétricos',
      'code' => '100046',
    ],
    [
      'id' => 6,
      'name' => 'Procesos Constructivos para Viviendas',
      'code' => '100047',
    ],
    [
      'id' => 7,
      'name' => 'Comunicación Gráfica en Ingeniería',
      'code' => '100048',
    ],
    [
      'id' => 8,
      'name' => 'Ensayos en Materiales de Construcción y Geotécnica',
      'code' => '100049',
    ],
    [
      'id' => 9,
      'name' => 'Requerimientos de Materiales',
      'code' => '100050',
    ],
    [
      'id' => 10,
      'name' => 'Normas y Especificaciones Técnicas',
      'code' => '100051',
    ],
    [
      'id' => 11,
      'name' => 'Dirección de Procesos Constructivos de Viviendas',
      'code' => '100052',
    ],
    [
      'id' => 12,
      'name' => 'Costos y Oferta Económica',
      'code' => '100053',
    ],
    [
      'id' => 13,
      'name' => 'Dibujo Digital de los Planos Constructivos',
      'code' => '100054',
    ],
    [
      'id' => 14,
      'name' => 'Instalaciones Hidráulicas',
      'code' => '100055',
    ],
    [
      'id' => 15,
      'name' => 'Instalaciones Eléctricas Residenciales',
      'code' => '100056',
    ],
    [
      'id' => 16,
      'name' => 'Plano Topográfico Digital',
      'code' => '100057',
    ],
    [
      'id' => 17,
      'name' => 'Edificaciones de Dos Niveles',
      'code' => '100058',
    ],
    [
      'id' => 18,
      'name' => 'Control de Calidad de los Materiales y de los Procesos Constructivos',
      'code' => '100059',
    ],
    [
      'id' => 19,
      'name' => 'Planos de Taller',
      'code' => '100060',
    ],
    [
      'id' => 20,
      'name' => 'Carpetas Técnicas',
      'code' => '100061',
    ],
    [
      'id' => 21,
      'name' => 'Supervisión de Obras',
      'code' => '100062',
    ],
    [
      'id' => 22,
      'name' => 'Medio Ambiente',
      'code' => '100063',
    ],
    [
      'id' => 23,
      'name' => 'Control del Avance Físico Financiero del Proyecto',
      'code' => '100064',
    ],
    [
      'id' => 24,
      'name' => 'Realidad Nacional',
      'code' => '100065',
    ],
    [
      'id' => 25,
      'name' => 'Práctica Profesional',
      'code' => '100066',
    ],
    [
      'id' => 26,
      'name' => 'Elaboración de Inventarios de Recursos Turísticos',
      'code' => '200039',
    ],
    [
      'id' => 27,
      'name' => 'Aplicación de Técnicas Elementales de Cocina',
      'code' => '200040',
    ],
    [
      'id' => 28,
      'name' => 'Seguridad e Higiene Ocupacional en la Hostelería y Turismo',
      'code' => '200041',
    ],
    [
      'id' => 29,
      'name' => 'Ética Profesional en la Hostelería y Turismo',
      'code' => '200042',
    ],
    [
      'id' => 30,
      'name' => 'Uso de Vocabulario en Inglés en la Hostelería',
      'code' => '200043',
    ],
    [
      'id' => 31,
      'name' => 'Diseño de Productos Turísticos Locales y Regionales',
      'code' => '200044',
    ],
    [
      'id' => 32,
      'name' => 'Aplicación de Técnicas Profesionales de Cocina',
      'code' => '200045',
    ],
    [
      'id' => 33,
      'name' => 'Gestión del Área de Recepción en la Industria Hotelera',
      'code' => '200046',
    ],
    [
      'id' => 34,
      'name' => 'plicación de Software y Redes Sociales en la Hostelería y Turismo',
      'code' => '200047',
    ],
    [
      'id' => 35,
      'name' => 'Etiqueta y Protocolo en Hostelería y Turismo',
      'code' => '200048',
    ],
    [
      'id' => 36,
      'name' => 'Comercialización de Productos Turísticos Locales y Regionales',
      'code' => '200049',
    ],
    [
      'id' => 37,
      'name' => 'Preparación de Bebidas',
      'code' => '200050',
    ],
    [
      'id' => 38,
      'name' => 'Gestión del Talento Humano en Empresas Turísticas y Hoteles',
      'code' => '200051',
    ],
    [
      'id' => 39,
      'name' => 'Aplicación de Técnicas de Guía Turístico',
      'code' => '200052',
    ],
    [
      'id' => 40,
      'name' => 'Uso de Vocabulario en Inglés en la Industria Turística',
      'code' => '200053',
    ],
    [
      'id' => 41,
      'name' => 'Mediación Turística en Agencias de Viajes',
      'code' => '200054',
    ],
    [
      'id' => 42,
      'name' => 'Preparación de Pan y Repostería',
      'code' => '200055',
    ],
    [
      'id' => 43,
      'name' => 'Gestión del Área de Alimentos y Bebidas en la Hostelería',
      'code' => '200056',
    ],
    [
      'id' => 44,
      'name' => 'Gestión de Eventos Turísticos',
      'code' => '200057',
    ],
    [
      'id' => 45,
      'name' => 'Diseño de Modelos de Negocios',
      'code' => '200058',
    ],
  ];

  private $curriculum = [
    [
      'id' => 1,
      'name' => 'Plan 2019-2020 de la carrera Técnico en Ingeniería de Construcción',
      'career_id' => 1,
      'year' => 2020,
      'is_active' => true,
      'is_approved' => false,
      'curriculum_subjects' => [
        [
          'id' => 1,
          'subject_id' => 1,
          'uv' => 3,
        ],
        [
          'id' => 2,
          'subject_id' => 2,
          'uv' => 2,
        ],
        [
          'id' => 3,
          'subject_id' => 3,
          'uv' => 3,
        ],
        [
          'id' => 4,
          'subject_id' => 4,
          'uv' => 4,
        ],
        [
          'id' => 5,
          'subject_id' => 5,
          'uv' => 5,
        ],
        [
          'id' => 6,
          'subject_id' => 6,
          'uv' => 3,
        ],
        [
          'id' => 7,
          'subject_id' => 7,
          'uv' => 3,
        ],
        [
          'id' => 8,
          'subject_id' => 8,
          'uv' => 4,
        ],
        [
          'id' => 9,
          'subject_id' => 9,
          'uv' => 3,
        ],
        [
          'id' => 10,
          'subject_id' => 10,
          'uv' => 3,
        ],
        [
          'id' => 11,
          'subject_id' => 11,
          'uv' => 5,
        ],
        [
          'id' => 12,
          'subject_id' => 12,
          'uv' => 5,
        ],
        [
          'id' => 13,
          'subject_id' => 13,
          'uv' => 4,
        ],
        [
          'id' => 14,
          'subject_id' => 14,
          'uv' => 3,
        ],
        [
          'id' => 15,
          'subject_id' => 15,
          'uv' => 3,
        ],
        [
          'id' => 16,
          'subject_id' => 16,
          'uv' => 3,
        ],
        [
          'id' => 17,
          'subject_id' => 17,
          'uv' => 5,
        ],
        [
          'id' => 18,
          'subject_id' => 18,
          'uv' => 5,
        ],
        [
          'id' => 19,
          'subject_id' => 19,
          'uv' => 5,
        ],
        [
          'id' => 20,
          'subject_id' => 20,
          'uv' => 4,
        ],
        [
          'id' => 21,
          'subject_id' => 21,
          'uv' => 5,
        ],
        [
          'id' => 22,
          'subject_id' => 22,
          'uv' => 2,
        ],
        [
          'id' => 23,
          'subject_id' => 23,
          'uv' => 4,
        ],
        [
          'id' => 24,
          'subject_id' => 24,
          'uv' => 2,
        ],
        [
          'id' => 25,
          'subject_id' => 25,
          'uv' => 4,
        ],
      ]
      ],
    [
      'id' => 2,
      'name' => 'Plan 2019-2020 de la carrera Técnico Superior en Hostelería y Turismo',
      'career_id' => 2,
      'year' => 2020,
      'is_active' => true,
      'is_approved' => false,
      'curriculum_subjects' => [
        [
          'id' => 26,
          'subject_id' => 26,
          'uv' => 4,
        ],
        [
          'id' => 27,
          'subject_id' => 27,
          'uv' => 5,
        ],
        [
          'id' => 28,
          'subject_id' => 28,
          'uv' => 4,
        ],
        [
          'id' => 29,
          'subject_id' => 29,
          'uv' => 3,
        ],
        [
          'id' => 30,
          'subject_id' => 30,
          'uv' => 4,
        ],
        [
          'id' => 31,
          'subject_id' => 31,
          'uv' => 5,
        ],
        [
          'id' => 32,
          'subject_id' => 32,
          'uv' => 5,
        ],
        [
          'id' => 33,
          'subject_id' => 33,
          'uv' => 5,
        ],
        [
          'id' => 34,
          'subject_id' => 34,
          'uv' => 4,
        ],
        [
          'id' => 35,
          'subject_id' => 35,
          'uv' => 3,
        ],
        [
          'id' => 36,
          'subject_id' => 36,
          'uv' => 3,
        ],
        [
          'id' => 37,
          'subject_id' => 37,
          'uv' => 4,
        ],
        [
          'id' => 38,
          'subject_id' => 38,
          'uv' => 4,
        ],
        [
          'id' => 39,
          'subject_id' => 39,
          'uv' => 4,
        ],
        [
          'id' => 40,
          'subject_id' => 40,
          'uv' => 4,
        ],
        [
          'id' => 41,
          'subject_id' => 41,
          'uv' => 4,
        ],
        [
          'id' => 42,
          'subject_id' => 42,
          'uv' => 4,
        ],
        [
          'id' => 43,
          'subject_id' => 43,
          'uv' => 3,
        ],
        [
          'id' => 44,
          'subject_id' => 44,
          'uv' => 5,
        ],
        [
          'id' => 45,
          'subject_id' => 45,
          'uv' => 4,
        ],
      ]
    ]
  ];

  private $prerequisites = [
    [
      'curriculum_subject_id' => 8,
      'prerequisite_id' => 1,
    ],
    [
      'curriculum_subject_id' => 9,
      'prerequisite_id' => 6,
    ],
    [
      'curriculum_subject_id' => 10,
      'prerequisite_id' => 6,
    ],
    [
      'curriculum_subject_id' => 13,
      'prerequisite_id' => 7,
    ],
    [
      'curriculum_subject_id' => 16,
      'prerequisite_id' => 13,
    ],
    [
      'curriculum_subject_id' => 17,
      'prerequisite_id' => 10,
    ],
    [
      'curriculum_subject_id' => 18,
      'prerequisite_id' => 13,
    ],
    [
      'curriculum_subject_id' => 19,
      'prerequisite_id' => 6,
    ],
    [
      'curriculum_subject_id' => 20,
      'prerequisite_id' => 17,
    ],
    // Borrar estos 2 registros: Los agregué para probar algo
    // [
    //   'curriculum_subject_id' => 45,
    //   'prerequisite_id' => 40,
    // ],
    // [
    //   'curriculum_subject_id' => 45,
    //   'prerequisite_id' => 41,
    // ],
  ];

  private $scholarships = [
    [
      'name' => 'Beca 1',
      'scholarship_foundation' => 'Fundacion 1',
    ],
    [
      'name' => 'Beca 2',
      'scholarship_foundation' => 'Fundacion 2',
    ],
  ];

  private $student_curricula = [
    [
      'cum' => 8.9,
      'entry_year' => 2017,
      'graduation_year' => 2022,
      'scholarship_rate' => 150,
    ],
    [
      'cum' => 6.5,
      'entry_year' => 2021,
      'graduation_year' => null,
      'scholarship_rate' => null,
    ],
  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    foreach ($this->careers as &$career) {
      Career::create([
        'id' => $career['id'],
        'name' => $career['name'],
      ]);
    }

    foreach ($this->subjects as &$subjects) {
      Subject::create([
        'id' => $subjects['id'],
        'name' => $subjects['name'],
        'code' => $subjects['code'],
      ]);
    }

    foreach ($this->curriculum as $curricula) {
      Curriculum::create([
        'id' => $curricula['id'],
        'career_id' => $curricula['career_id'],
        'name' => $curricula['name'],
        'year' => $curricula['year'],
        'is_active' => $curricula['is_active'],
        'is_approved' => $curricula['is_approved'],
      ]);

      foreach ($curricula['curriculum_subjects'] as $cusub) {
        CurriculumSubject::create([
          'id' => $cusub['id'],
          'curriculum_id' => $curricula['id'],
          'subject_id' => $cusub['subject_id'],
          'uv' => $cusub['uv'],
        ]);
      }
    }

      foreach ($this->prerequisites as $prereq) {
        Prerequisite::create([
          'prerequisite_id' => $prereq['prerequisite_id'],
          'curriculum_subject_id' => $prereq['curriculum_subject_id'],
        ]);
      }

      foreach ($this->scholarships as $scholar) {
        Scholarship::create([
          'name' => $scholar['name'],
          'scholarship_foundation' => $scholar['scholarship_foundation'],
        ]);
      }

      foreach ($this->student_curricula as $stude) {
        StudentCurriculum::create([
          'cum' => $stude['cum'],
          'entry_year' => $stude['entry_year'],
          'graduation_year' => $stude['graduation_year'],
          'scholarship_rate' => $stude['scholarship_rate'],
          'student_id' => Student::all()->random()->id,
          'curriculum_id' => Curriculum::all()->random()->id,
          'scholarship_id' => Scholarship::all()->random()->id,
        ]);
      }
  }
}
