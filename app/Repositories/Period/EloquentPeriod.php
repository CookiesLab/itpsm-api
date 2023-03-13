<?php

/**
 * @file
 * EloquentPeriod
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\Period;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Period;
use App\Models\Enrollment;
use App\Models\StudentCurriculum;
use App\Models\CurriculumSubject;
use App\Models\AcademicHistory;
use Illuminate\Support\Facades\Log;



class EloquentPeriod implements PeriodInterface
{
  protected $CurriculumSubject;
  protected $StudentCurriculum;
  protected $Enrollment;
  protected $AcademicHistory;

  /**
   * Period
   *
   * @var App\Models\Period;
   *
   */
  protected $Period;



  /**
   * DB
   *
   * @var Illuminate\Support\Facades\DB;
   *
   */
  protected $DB;

  public function __construct(Model $CurriculumSubject,Model $StudentCurriculum,Model $Enrollment,Model $Period,Model $AcademicHistory, DB $DB)
  {
    $this->CurriculumSubject=$CurriculumSubject;
    $this->StudentCurriculum=$StudentCurriculum;
    $this->Enrollment=$Enrollment;
    $this->AcademicHistory=$AcademicHistory;
    $this->Period = $Period;
    $this->DB = $DB;
  }

  /**
   * Retrieve list of Periods
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null)
  {
    $query = $this->DB::table('periods AS p')
      ->select(
        'p.id',
        'p.code',
        'p.year',
        'p.status'
      );


    if (!empty($filter)) {
      $query->where(function ($dbQuery) use ($filter) {
        foreach (['p.code', 'p.year', 'p.status'] as $key => $value) {
          $dbQuery->orWhere($value, 'like', '%' . str_replace(' ', '%', $filter) . '%');
        }
      });
    }

    if (!empty($sortColumn) && !empty($sortOrder)) {
      $query->orderBy($sortColumn, $sortOrder);
    }

    if ($count) {
      return $query->count();
    }

    if (!empty($limit)) {
      $query->take($limit);
    }

    if (!empty($offset) && $offset != 0) {
      $query->skip($offset);
    }
    return new Collection(
      $query->get()
    );
  }

  public function getActiveToBeEnrolled()
  {
    Log::emergency( date('Y'));
    return $this->Period
      ->where('status', '=', 'I')
    //  ->where('year', '=', date('Y'))
      ->first();
  }


  /**
   * Get an Period by id
   *
   * @param  int $id
   *
   * @return App\Models\Period
   */
  public function byId($id)
  {
    return $this->Period->find($id);
  }

  /**
   * Create a new Period
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @return App\Models\Period $Period
   */
  public function create(array $data)
  {

    if($data['status']=="I" || $data['status']=="A"){

        $query = $this->DB::table('periods AS p')
        ->select(
          'p.id',
          'p.code',
          'p.year',
          'p.status'
        )->where('p.status', '=', $data['status'])->first();
        if($query == null){
          $period = new Period();
          $period->fill($data)->save();

          return $period;
        }else{
          return null;
        }


    }

    $period = new Period();
    $period->fill($data)->save();

    return $period;

  }

  /**
   * Update an existing Period
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @param App\Models\Period $Period
   *
   * @return boolean
   */
  public function update(array $data, $period = null)
  {
    if($data['status']=="I" || $data['status']=="A"){

      $query = $this->DB::table('periods AS p')
      ->select(
        'p.id',
        'p.code',
        'p.year',
        'p.status'
      )->where('p.status', '=', $data['status'])->first();
      if($query == null){
        $period = $this->byId($data['id']);
        return $period->update($data);
      }else{
        return null;
      }


  }
    //Se sigue con el proceso de cerrar ciclo si es que existen estudiantes cursando
    if($data['status']=="C") {
      $sections = $this->DB::table('sections AS s')
        ->where('s.period_id', '=', $data['id'])->get();
        foreach ($sections as $section) {
          //obtener estudiantes en la sección
          $students = $this->Enrollment->where('code', '=', $section->id)->get();
          //obtener las evaluaciones de esta sección
          $evaluations = $this->DB::table('evaluations AS e')
          ->where('e.section_id', '=', $section->id)->where('e.status', '!=', null)->get();

          foreach ($students as $student) {
            $total = 0;
            foreach ($evaluations as $evaluation) { // calcular nota final del curso
              $grade = $this->DB::table('score_evaluations AS e')
                ->join('evaluations as eval', 'eval.id', '=', 'e.evaluation_id')
                ->where('e.student_id', '=', $student->student_id)
                ->where('e.evaluation_id', '=', $evaluation->id)
                ->where('eval.level', '=', 1)
                ->first();
              if (!empty($grade)) {
                $total += $grade->score * $evaluation->percentage / 100;
              }
            }
          $student->final_score = $total;

          //validación para comprobar si aprobó o no
          if ($total > 6) {
            $student->is_approved = 1;
          } else {
            $student->is_approved = 0;
          }
          $student->save();
        }
      }
      //Agregando esta información al Historial del estudiante
      $students = $this->Enrollment->select(DB::raw('distinct(student_id)'))
        ->join('sections as st', 'st.id', '=', 'enrollments.code')
        ->where('st.period_id', '=', $data['id'])->get();
      if ($students != null) {
        foreach ($students as $student) {

          $subjects = $this->Enrollment
            ->where('student_id', '=', $student->student_id)->get();
          $total = 0;
          $uv_a = 0;
          $uv_sum = 0;

          foreach ($subjects as $subject) {
            $uv = $this->CurriculumSubject->where('id', '=', $subject->curriculum_subject_id)->first();
            Log::emergency("uv de materias");
            Log::emergency($uv);
            $grade = $subject->final_score;
            if ($grade > 6.0) {
              $uv_a += $uv->uv;
            }
            if (!empty($grade)) {
              $total += $grade * $uv->uv;
              $uv_sum += $uv->uv;
            }
          }
          $curriculum = $this->StudentCurriculum->where('student_id', '=', $student->student_id)->first();
          if($curriculum != null) {
            Log::emergency("Data estudiante");
            Log::emergency($curriculum);
            Log::emergency( $curriculum->uv_total);
            $curriculum->uv = $uv_a;
            $curriculum->level = $curriculum->uv / $curriculum->uv_total;
            $curriculum->level = $curriculum->level + 1;
            if ($uv_sum > 0) {
              $curriculum->cum = $total / $uv_sum;
            } else {
              $curriculum->cum = 0.00;
            }

            Log::emergency("estudiante al final");
            Log::emergency($curriculum);
            $curriculumid=$curriculum->curriculum_id;
            $curriculum->save();

            //HISTORIAL ACADEMICO POR ESTUDIANTE
//        Log::emergency($section->curriculum_subject_id);
//          Log::emergency($curriculumxsubject);
            $studentAchistory = new $this->AcademicHistory;
            $studentAchistory->student_id = $student->student_id;
            $studentAchistory->totalScore = $total;
            $studentAchistory->isEquivalence = 0;
            $studentAchistory->year = date('Y');
            $studentAchistory->period = date('m');
            $studentAchistory->subject_id = 3;
            $studentAchistory->curriculum_id = $curriculumid;
            $studentAchistory->save();
          }
        }
        $period = $this->byId($data['id']);
        return $period->update($data);

      }
    }
    $period = $this->byId($data['id']);
    return $period->update($data);
  }

  /**
   * Delete existing Period
   *
   * @param integer $id
   * 	An Period id
   *
   * @return boolean
   */
  public function delete($id)
  {
    return $this->Period->destroy($id);
  }
}
