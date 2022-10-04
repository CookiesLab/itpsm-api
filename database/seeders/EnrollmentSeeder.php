<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section;
use App\Models\Period;
use App\Models\Enrollment;
use App\Models\Evaluation;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Schedule;

use App\Models\CurriculumSubject;
use App\Models\ScoreEvaluation;

class EnrollmentSeeder extends Seeder
{
    private $periods = [
        [
            'code' => 01,
            'year' => 2022,
            'status' => 'C'
        ],
        [
            'code' => 02,
            'year' => 2022,
            'status' => 'C'
        ],
        [
            'code' => 03,
            'year' => 2022,
            'status' => 'I',
        ],
    ];

  private $schedules = [
    [

      'start_hour' => '7:30',
      'end_hour' => '8:20'
    ], [

      'start_hour' => '8:20',
      'end_hour' => '9:10'
    ],   [

      'start_hour' => '9:20',
      'end_hour' => '10:10'
    ], [

      'start_hour' => '10:10',
      'end_hour' => '11:00'
    ],   [

      'start_hour' => '11:10',
      'end_hour' => '12:00'
    ],   [

      'start_hour' => '1:00',
      'end_hour' => '1:50'
    ], [

      'start_hour' => '1:50',
      'end_hour' => '2:40'
    ],
    [

      'start_hour' => '2:50',
      'end_hour' => '3:40'
    ], [

      'start_hour' => '3:40',
      'end_hour' => '4:30'
    ],
  ];

    private $sections = [
        [
            'code' => 1,
            'quota' => 25,
            'id_schedule' => 1,
        ],
        [
            'code' => 1,
            'quota' => 45,
          'id_schedule' => 1,
        ],
        [
            'code' => 1,
            'quota' => 15,
          'id_schedule' => 1,
        ],
    ];

    private $evaluations = [
        [
            'name' => 'Parcial 1',
            'description' => 'Parcial 1',
            'date' => '2022-02-02',
            'percentage' => 20.5,
        ],
        [
            'name' => 'Parcial 2',
            'description' => 'Parcial 2',
            'date' => '2022-02-02',
            'percentage' => 50,
        ],
        [
            'name' => 'Parcial 3',
            'description' => 'Parcial 3',
            'date' => '2022-02-05',
            'percentage' => 30,
        ],
    ];

    private $enrollments = [
        [
            'code' => 1,
            'final_score' => 8.5,
            'is_approved' => true,
            'enrollment' => 1,
        ],
        [
            'code' => 1,
            'final_score' => 7.5,
            'is_approved' => false,
            'enrollment' => 3,
        ],
        [
            'code' => 1,
            'final_score' => 5.6,
            'is_approved' => true,
            'enrollment' => 4,
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->periods as &$period) {
            Period::create([
              'code' => $period['code'],
              'year' => $period['year'],
              'status' => $period['status'],
            ]);
        }
        for ($i=1; $i<=5;$i++){
          foreach ($this->schedules as &$schedule) {
            Schedule::create([
              'day_of_week' => $i,
              'start_hour' => $schedule['start_hour'],
              'end_hour' => $schedule['end_hour'],
            ]);
          }
    }


        foreach ($this->sections as &$section) {
            Section::create([
              'teacher_id' => Teacher::all()->random()->id,
              'curriculum_subject_id' => CurriculumSubject::all()->random()->id,
              'period_id' => Period::all()->random()->id,
              'quota' => $section['quota'],
              'id_schedule' => $section['id_schedule'],
              'code' => $section['code'],
            ]);
        }

        foreach ($this->evaluations as &$evaluation) {
            Evaluation::create([
              'name' => $evaluation['name'],
              'description' => $evaluation['description'],
              'date' => $evaluation['date'],
              'percentage' => $evaluation['percentage'],
              'section_id' => Section::all()->random()->code,
            ]);
        }

        foreach ($this->enrollments as &$enrollment) {
            Enrollment::create([
              'student_id' => Student::all()->random()->id,
              'teacher_id' => Teacher::all()->random()->id,
              'curriculum_subject_id' => CurriculumSubject::all()->random()->id,
              'period_id' => Period::all()->random()->id,
              'code' => $enrollment['code'],
              'final_score' => $enrollment['final_score'],
              'is_approved' => $enrollment['is_approved'],
              'enrollment' => $enrollment['enrollment'],
            ]);
        }

        ScoreEvaluation::create([
            'student_id' => Student::all()->random()->id,
            'evaluation_id' => Evaluation::all()->random()->id,
            'score' => 8,
        ]);
    }
}
