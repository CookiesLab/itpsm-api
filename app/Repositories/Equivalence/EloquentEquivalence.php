<?php

/**
 * @file
 * EloquentCurriculum
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\Equivalence;

use App\Models\Equivalence;
use App\Models\AcademicHistory;
use App\Repositories\Equivalence\EquivalenceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Curriculum;
use App\Models\CurriculumSubject;
use App\Models\Subject;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Log;

class EloquentEquivalence implements EquivalenceInterface
{

  /**
   * Curriculum
   *
   * @var App\Models\Equivalence;
   *
   */
  protected $Curriculum;

  /**
   * AcademicHistory
   *
   * @var App\Models\AcademicHistory;
   *
   */
  protected $AcademicHistory;


  /**
   * Subjects
   *
   * @var App\Models\Subjects
   *
   */
  protected $Subject;

  /**
   * Studentcurriculum
   *
   * @var App\Models\StudentCurriculum
   *
   */
  protected $StudentCurriculum;
  /**
   * CurriculumSubject
   *
   * @var App\Models\CurriculumSubject
   *
   */
  protected $CurriculumSubject;

  /**
   * Enrollment
   *
   * @var App\Models\Enrollment
   *
   */
  protected $Enrollment;



  /**
   * DB
   *
   * @var Illuminate\Support\Facades\DB;
   *
   */
  protected $DB;

  public function __construct(Model $Curriculum,Model $AcademicHistory,Model $StudentCurriculum,Model $CurriculumSubject,Model $Subject,Model $Enrollment, DB $DB)
  {
    $this->Curriculum = $Curriculum;
    $this->AcademicHistory = $AcademicHistory;
    $this->Subject = $Subject;
    $this->StudentCurriculum = $StudentCurriculum;
    $this->CurriculumSubject = $CurriculumSubject;
    $this->Enrollment= $Enrollment;
    $this->DB = $DB;

  }

  /**
   * Retrieve list of Curricula
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null)
  {
    $query = $this->DB::table('equivalence AS e')
      ->select(
        'e.id',
        'e.AcademicHistory_id',
        's.name',
        'e.subjectname',
        'e.institution',
        'e.IsinnerEquivalence'
      )
      ->join('subjects as s', 's.id', '=', 'e.subject_id')
    ;

    if (!empty($filter)) {
      $query->where(function ($dbQuery) use ($filter) {
        foreach (['c.name', 'c.year', 'ca.name'] as $key => $value) {
          $dbQuery->orWhere($value, 'like', '%' . str_replace(' ', '%', $filter) . '%');
          //$dbQuery->orwhereRaw('lower(`' . $value . '`) LIKE ? ',['%' . strtolower(str_replace(' ', '%', $filter)) . '%']);
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

  /**
   * Get an Curriculum by id
   *
   * @param  int $id
   *
   * @return App\Models\Equivalence
   */
  public function byId($id)
  {
//    return $this->Curriculum->find($id);
    $query = $this->DB::table('equivalence AS e')
      ->select(
        'e.id',
        'e.AcademicHistory_id',
        's.name',
        'e.subjectname',
        'e.institution',
        'e.IsinnerEquivalence',
        'ah.student_id'
      )->join('academic_history as ah','ah.id', '=','e.AcademicHistory_id')
      ->join('subjects as s', 's.id', '=', 'e.subject_id')
      ->where('ah.student_id','=',$id);

    return new Collection(
      $query->get()
    );
  }

  /**
   * Create a new Curriculum
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @return App\Models\Curriculum $Curriculum
   */
  public function create(array $data)
  {

    $studentAchistory = new $this->AcademicHistory();
    $studentAchistory->student_id = $data["id"];
    $studentAchistory->totalScore = $data["score"];
    $studentAchistory->isEquivalence = 1;
    $studentAchistory->year = date('Y');
    $studentAchistory->period = date('m');
    $studentAchistory->subject_id = $data["curriculum_subject_id"];
    $studentAchistory->curriculum_id = $data["curricula_id"];
    $studentAchistory->save();
    //agregar a enrollment
    $enrollment = new $this->Enrollment();
    $enrollment->curriculum_subject_id =$data["curriculum_subject_id"];
    $enrollment->student_id = $data["id"];
    $enrollment->is_approved=1;
    $enrollment->final_score=$data["score"];
    $enrollment->save();


    $equivalence = new $this->Curriculum();
    if($data["IsInnerEquivalence"]==0) {

      $equivalence->AcademicHistory_id = $studentAchistory->id;
      $equivalence->subjectname = $data["subjectname"];
      $equivalence->institution = $data["institution"];
      $equivalence->subject_id = $data["curriculum_subject_id"];
      $equivalence->IsinnerEquivalence = 0;

    }else{
      Log::emergency("Inner Equivalence");
      Log::emergency($data);
      $subjectname = $this->Subject->where('id','=',$data["curriculum_subject_id"])->first();
      Log::emergency($subjectname);
      $equivalence = new $this->Curriculum();
      $equivalence->subjectname = $subjectname->name;
      $equivalence->institution = "INSTITUTO TECNOLOGICO PADRE SEGUNDO MONTES";
      $equivalence->subject_id = $data["curriculum_subject_id"];
      $equivalence->IsinnerEquivalence = 1;

    }
    Log::emergency($equivalence);
    $equivalence->save();

    //recalcular cum
    //declaración de variables
    $total =0;
    $uv_a=0;
    $uv_sum=0;

    $uv=$this->CurriculumSubject->where('id', '=',$data["curriculum_subject_id"])->first();
    Log::emergency("uv de  materias");
    Log::emergency($uv);

    $grade= $data["score"];
    if (!empty($grade)) {
      $total += $grade * $uv->uv;
      Log::emergency($total);
      $uv_sum += $uv->uv;
      Log::emergency($uv);
    }

    $curriculum = $this->StudentCurriculum->where('student_id', '=', $studentAchistory->student_id )->first();
    if($curriculum != null) {
      Log::emergency($uv_a);
      $curriculum->uv += $uv_sum;

      if ($curriculum->uv_total!=0){
        $curriculum->level = $curriculum->uv / $curriculum->uv_total;
        $curriculum->level = $curriculum->level + 1;
      }else{
        $curriculum->level = 0;

      }



      Log::emergency($uv_sum);
      if ($uv_sum > 0) {
        $curriculum->cum = $total / $uv_sum;
      } else {
        $curriculum->cum = 0.00;
      }
      $curriculum->save();
    }

    return $equivalence;
  }

  /**
   * Update an existing Curriculum
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @param App\Models\Curriculum $Curriculum
   *
   * @return boolean
   */
  public function update(array $data, $curriculum = null)
  {
    if (empty($curriculum)) {
      $curriculum = $this->byId($data['id']);
    }

    return $curriculum->update($data);
  }

  /**
   * Delete existing Curriculum
   *
   * @param integer $id
   * 	An Curriculum id
   *
   * @return boolean
   */
  public function delete($id)
  {
    return $this->Curriculum->destroy($id);
  }
}
