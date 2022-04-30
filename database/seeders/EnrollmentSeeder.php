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
            'id' => 1,
            'code' => 01,
            'year' => 2022,
        ],
        [
            'id' => 2,
            'code' => 02,
            'year' => 2022,
        ],
        [
            'id' => 3,
            'code' => 03,
            'year' => 2022,
        ],
    ];

    private $sections = [
        [
            'code' => 1,
            'quota' => 25,
            'schedule' => 'horario',
        ],
        [
            'code' => 2,
            'quota' => 45,
            'schedule' => 'horario',
        ],
        [
            'code' => 3,
            'quota' => 15,
            'schedule' => 'horario',
        ],
    ];

    private $evaluations = [
        [
            'id' => 1,
            'name' => 'Parcial 1',
            'description' => 'Parcial 1',
            'date' => '2022-02-02',
            'porcentaje' => 20.5,
        ],
        [
            'id' => 2,
            'name' => 'Parcial 2',
            'description' => 'Parcial 2',
            'date' => '2022-02-02',
            'porcentaje' => 50,
        ],
        [
            'id' => 3,
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
              'id' => $period['id'],
              'code' => $period['code'],
              'year' => $period['year'],
            ]);
        }

        foreach ($this->sections as &$section) {
            Section::create([
              'teacher_id' => Teacher::all()->random()->id,
              'curriculum_subject_id' => CurriculumSubject::all()->random()->id,
              'period_id' => $period['id'],
              'code' => $section['code'],
              'quota' => $section['quota'],
              'schedule' => $section['schedule'],
            ]);
        }

        foreach ($this->evaluations as &$evaluation) {
            Evaluation::create([
              'id' => $evaluation['id'],
              'name' => $evaluation['name'],
              'description' => $evaluation['description'],
              'date' => $evaluation['date'],
              'porcentaje' => $evaluation['porcentaje'],
              'section_id' => $section['code'],
            ]);
        }

        foreach ($this->enrollments as &$enrollment) {
            Enrollment::create([
              'student_id' => Student::all()->random()->id,
              'teacher_id' => Teacher::all()->random()->id,
              'curriculum_subject_id' => CurriculumSubject::all()->random()->id,
              'period_id' => $period['code'],
              'code' => $enrollment['code'],
              'final_score' => $enrollment['final_score'],
              'is_approved' => $enrollment['is_approved'],
              'enrollment' => $enrollment['enrollment'],
            ]);
        }

        ScoreEvaluation::create([
            'student_id' => Student::all()->random()->id,
            'evaluation_id' => $evaluation['id'],
            'score' => 8,
        ]);
    }
}
