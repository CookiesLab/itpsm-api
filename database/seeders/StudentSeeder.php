<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Disability;
use App\Models\MedicalExam;
use App\Models\StudentDisability;
use App\Models\StudentMedicalExam;


class StudentSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */

  private $disabilities = [
    [
      'disability' => 'Ceguera parcial',
      'subdisability' => null,
    ],
    [
      'disability' => 'Ceguera total',
      'subdisability' => null,
    ],
  ];

  private $student_disabilities = [
    [
      'disability_id' => 2,
      'student_id' => 1,
    ],
    [
      'disability_id' => 1,
      'student_id' => 2,
    ],
  ];

  private $medical_exams = [
    [
      'name' => 'Examen de la vista',
      'description' => 'Vista 001, prueba de la vista',
    ],
    [
      'name' => 'Consulta general',
      'description' => 'Consulta general seguro social',
    ],
  ];

  private $student_medical_exams = [
    [
      'remark' => null,
      'realization_date' => '2019-03-03',
      'expiration_date' => '2012-03-08',
    ],
    [
      'remark' => null,
      'realization_date' => '2021-01-03',
      'expiration_date' => '2013-07-08',
    ],
  ];

  public function run()
  {
    Student::factory(10)->create();

    foreach ($this->disabilities as &$disa) {
      Disability::create([
        'disability' => $disa['disability'],
        'subdisability' => $disa['subdisability'],
      ]);
    }

    foreach ($this->student_disabilities as &$studisa) {
      StudentDisability::create([
        'disability_id' => $studisa['disability_id'],
        'student_id' => $studisa['student_id'],
      ]);
    }

    foreach ($this->medical_exams as &$med) {
      MedicalExam::create([
        'name' => $med['name'],
        'description' => $med['description'],
      ]);
    }

    foreach ($this->student_medical_exams as &$st) {
      StudentMedicalExam::create([
        'remark' => $st['remark'],
        'realization_date' => $st['realization_date'],
        'expiration_date' => $st['expiration_date'],
        'exam_id' => MedicalExam::all()->random()->id,
        'student_id' => Student::all()->random()->id,
      ]);
    }
  }
}
