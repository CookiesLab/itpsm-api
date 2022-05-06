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
use App\Models\CurriculumSubject;
use App\Models\ScoreEvaluation;

class EnrollmentSeeder extends Seeder
{
    private $periods = [
        [
            'code' => 01,
            'year' => 2022,
        ],
        [
            'code' => 02,
            'year' => 2022,
        ],
        [
            'code' => 03,
            'year' => 2022,
        ],
    ];

    private $sections = [
        [
            'quota' => 25,
            'schedule' => 'horario',
        ],
        [
            'quota' => 45,
            'schedule' => 'horario',
        ],
        [
            'quota' => 15,
            'schedule' => 'horario',
        ],
    ];

    private $evaluations = [
        [
            'name' => 'Parcial 1',
            'description' => 'Parcial 1',
            'date' => '2022-02-02',
            'porcentaje' => 20.5,
        ],
        [
            'name' => 'Parcial 2',
            'description' => 'Parcial 2',
            'date' => '2022-02-02',
            'porcentaje' => 50,
        ],
        [
            'name' => 'Parcial 3',
            'description' => 'Parcial 3',
            'date' => '2022-02-05',
            'porcentaje' => 30,
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
            'code' => 2,
            'final_score' => 7.5,
            'is_approved' => false,
            'enrollment' => 3,
        ],
        [
            'code' => 3,
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
            ]);
        }

        foreach ($this->sections as &$section) {
            Section::create([
              'teacher_id' => Teacher::all()->random()->id,
              'curriculum_subject_id' => CurriculumSubject::all()->random()->id,
              'period_id' => Period::all()->random()->id,
              'quota' => $section['quota'],
              'schedule' => $section['schedule'],
            ]);
        }

        foreach ($this->evaluations as &$evaluation) {
            Evaluation::create([
              'name' => $evaluation['name'],
              'description' => $evaluation['description'],
              'date' => $evaluation['date'],
              'porcentaje' => $evaluation['porcentaje'],
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
