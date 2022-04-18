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
            'curricula' => [
                [
                    'id' => 1,
                    'name' => 'algo',
                    'year' => 2022,
                    'is_active' => true,
                    'subjects' => [
                        [
                            'id' => 1,
                            'name' => 'algo',
                            'code' => '001',
                            'cusub' => [
                                [
                                    'id' => 20,
                                    'uv' => 10,
                                ]
                            ] 
                        ]
                    ]
                ]
            ]
        ],
        [
            'id' => 2,
            'name' => 'Técnico Superior en Hostelería y Turismo',
            'curricula' => [
                [
                    'id' => 2,
                    'name' => 'algo',
                    'year' => 2022,
                    'is_active' => true,
                    'subjects' => [
                        [
                            'id' => 2,
                            'name' => 'algo',
                            'code' => '002',
                            'cusub' => [
                                [
                                    'id' => 21,
                                    'uv' => 20,
                                ]
                            ]
                        ]
                    ]
                ]
            ]
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
      
            foreach ($career['curricula'] as $curricula) {
              Curriculum::create([
                'id' => $curricula['id'],
                'career_id' => $career['id'],
                'name' => $curricula['name'],
                'year' => $curricula['year'],
                'is_active' => $curricula['is_active'],
              ]);

              foreach ($curricula['subjects'] as $subjects) {
                  Subject::create([
                      'id' => $subjects['id'],
                      'name' => $subjects['name'],
                      'code' => $subjects['code'],
                  ]);

                  foreach ($subjects['cusub'] as $subject) {
                      CurriculumSubject::create([
                          'id' => $subject['id'],
                          'curriculum_id' => $curricula['id'],
                          'subject_id' => $subjects['id'],
                          'uv' => $subject['uv'],
                      ]);
                  }
              }
            }
          }
    }
}
