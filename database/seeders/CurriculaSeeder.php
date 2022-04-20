<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Career;
use App\Models\Curriculum;
use App\Models\Subject;
use App\Models\CurriculumSubject;

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
        ]
    ];

    private $curriculum = [
        [
            'id' => 1,
            'name' => 'Plan 2019-2020',
            'year' => 2020,
            'is_active' => true,
            'curriculum_subjects' => [
                [
                    'id' => 1,
                    'uv' => 83, 
                ]
            ]
        ]
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
                'career_id' => $career['id'],
                'name' => $curricula['name'],
                'year' => $curricula['year'], 
                'is_active' => $curricula['is_active'], 
            ]);
        }

        foreach ($curriculum['curriculum_subjects'] as $cusub) {
            CurriculumSubject::create([
              'id' => $cusub['id'],
              'curriculum_id' => $curricula['id'],
              'subject_id' => $subjects['id'],
              'uv' => $cusub['uv'],
            ]);
          }
    }
}
