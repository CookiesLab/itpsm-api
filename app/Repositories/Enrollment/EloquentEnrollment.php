<?php

/**
 * @file
 * EloquentEnrollment
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\Enrollment;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Log;
use League\OAuth2\Server\Grant\AbstractAuthorizeGrant;

class EloquentEnrollment implements EnrollmentInterface
{

  /**
   * Enrollment
   *
   * @var App\Models\Enrollment;
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

  public function __construct(Model $Enrollment, DB $DB)
  {
    $this->Enrollment = $Enrollment;
    $this->DB = $DB;
  }

  /**
   * Retrieve list of Enrollments
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null)
  {
    $query = $this->DB::table('enrollments AS e')
      ->select(
        'e.final_score',
        'e.is_approved',
        'e.enrollment',
        'e.curriculum_subject_id',
        'e.period_id',
        'e.code',
        'e.student_id',
        'e.teacher_id'
      );


    if (!empty($filter)) {
      $query->where(function ($dbQuery) use ($filter) {
        foreach (['t.name', 't.last_name', 't.email', 't.nit', 't.dui', 't.nup_number', 't.isss_number'] as $key => $value) {
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
   * Get an Enrollment by id
   *
   * @param  int $id
   *
   * @return App\Models\Enrollment
   */
  public function byId($id)
  {
    $ids = get_keys_data($id);

    return $this->StudentCurriculum
      ->where('student_id', intval($ids[0]))
      ->where('teacher_id', intval($ids[1]))
      ->where('curriculum_subject_id', intval($ids[2]))
      ->where('period_id', intval($ids[3]))
      ->where('code', intval($ids[4]))
      ->first();
  }

      /**
   * Get sections by period id
   *
   * @param integer $id
   *
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getCurriculumSubjectsApproved($studentId)
  {
    return new Collection(
      $this->DB::table('enrollments AS e')
        ->select(
          'e.final_score',
          'e.is_approved',
          'e.curriculum_subject_id',
          'st.period_id',
          'e.code',

          'e.enrollment',
          'p.year AS period_year',
          'p.code AS period_code',
          'm.name AS curriculum_subject_label',
          'c.name AS curriculum_label',
          'ca.name AS career_label',
          $this->DB::raw('CONCAT(t.name, \' \', t.last_name) AS teacher_name'),
        )
        ->join('sections as st', 'st.id', '=', 'e.code')
        ->leftJoin('teachers as t', 'st.teacher_id', '=', 't.id')
        ->join('curriculum_subjects as cs', 'e.curriculum_subject_id', '=', 'cs.id')
        ->join('curricula as c', 'cs.curriculum_id', '=', 'c.id')
        ->join('periods as p', 'st.period_id', '=', 'p.id')
        ->join('careers as ca', 'c.career_id', '=', 'ca.id')
        ->join('subjects as m', 'cs.subject_id', '=', 'm.id')
        ->where('e.student_id', $studentId)
        ->where('e.is_approved', true)
        ->orderBy('cs.cycle', 'asc')
        ->get()
    );
  }
  /**
   * Get sections by period id
   *
   * @param integer $id
   *
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getCurriculumSubjectsEvaluated($studentId)
  {
    return new Collection(
      $this->DB::table('enrollments AS e')
        ->select(
          'e.final_score',
          'e.is_approved',
          'e.curriculum_subject_id',
          'st.period_id',
          'e.code',

          'e.enrollment',
          'p.year AS period_year',
          'p.code AS period_code',
          'm.name AS curriculum_subject_label',
          'c.name AS curriculum_label',
          'ca.name AS career_label',
          $this->DB::raw('CONCAT(t.name, \' \', t.last_name) AS teacher_name'),
        )
        ->join('sections as st', 'st.id', '=', 'e.code')
        ->leftJoin('teachers as t', 'st.teacher_id', '=', 't.id')
        ->join('curriculum_subjects as cs', 'e.curriculum_subject_id', '=', 'cs.id')
        ->join('curricula as c', 'cs.curriculum_id', '=', 'c.id')
        ->join('periods as p', 'st.period_id', '=', 'p.id')
        ->join('careers as ca', 'c.career_id', '=', 'ca.id')
        ->join('subjects as m', 'cs.subject_id', '=', 'm.id')
        ->where('e.student_id', $studentId)
        ->orderBy('cs.cycle', 'asc')
        ->get()
    );
  }
  /**
   * Get sections by period id
   *
   * @param integer $id
   *
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getCurriculumSubjectsEvaluatedforReport($studentId)
  {
    return new Collection(
      $this->DB::table('enrollments AS e')
        ->select(
          'e.final_score',
          'e.is_approved',
          'e.curriculum_subject_id',
          'st.period_id',
          'cs.uv',
          'e.code',
          'e.enrollment',
          'p.year AS period_year',
          'p.code AS period_code',
          'm.name AS curriculum_subject_label',
          'm.code AS curriculum_subject_code',
          'm.id AS curriculum_subject_order',
          'c.name AS curriculum_label',
          'ca.name AS career_label',
          $this->DB::raw('CONCAT(t.name, \' \', t.last_name) AS teacher_name'),
        )
        ->join('sections as st', 'st.id', '=', 'e.code')
        ->leftJoin('teachers as t', 'st.teacher_id', '=', 't.id')
        ->join('curriculum_subjects as cs', 'e.curriculum_subject_id', '=', 'cs.id')
        ->join('curricula as c', 'cs.curriculum_id', '=', 'c.id')
        ->join('periods as p', 'st.period_id', '=', 'p.id')
        ->join('careers as ca', 'c.career_id', '=', 'ca.id')
        ->join('subjects as m', 'cs.subject_id', '=', 'm.id')
        ->where('e.student_id', $studentId)
        ->orderBy('cs.cycle', 'asc')
        ->whereNotNull('e.final_score')
          ->get()
    );
  }
  public function getperiodsforStudent($id)
  {
    return new Collection(
      $this->DB::table('enrollments AS e')
        ->select(
          'p.*',
        )
        ->join('sections as st', 'st.id', '=', 'e.code')
        ->join('periods as p', 'st.period_id', '=', 'p.id')
        ->where('e.student_id', $id)
        ->distinct('p.id')
        ->orderBy('p.id', 'asc')
        //->whereNotNull('e.final_score')
        ->get()
    );
  }
  public function getsubjectforperiodsforStudent($id)
  {

    return new Collection(
      $this->DB::table('enrollments AS e')
        ->selectRaw('p.id, count(*) as total')
        ->join('sections as st', 'st.id', '=', 'e.code')
        ->join('periods as p', 'st.period_id', '=', 'p.id')
        ->where('e.student_id', $id)
        ->distinct('p.id')
        ->orderBy('p.id', 'asc')
        ->groupBy('p.id')
        ->whereNotNull('e.final_score')
        ->get()
    );
  }
  /**
   * Get sections by period id
   *
   * @param integer $id
   *
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function byStudentIdAndPeriodId($studentId, $periodId)
  {
    return new Collection(
      $this->DB::table('enrollments AS e')
        ->select(
          'e.final_score',
          'e.is_approved',
          'e.curriculum_subject_id',

          'e.code',
          'e.enrollment',
          'p.year AS period_year',
          'p.code AS period_code',
          'p.code AS period_code',
          'm.name AS curriculum_subject_label',
          'c.name AS curriculum_label',
          'ca.name AS career_label',
          'cs.uv AS curriculum_subject_uv',

          $this->DB::raw('CONCAT(t.name, \' \', t.last_name) AS teacher_name'),
          'st.start_week','st.end_week'
        )
        ->join('sections as st', 'st.id', '=', 'e.code')
        ->leftJoin('teachers as t', 'st.teacher_id', '=', 't.id')

        ->join('curriculum_subjects as cs', 'e.curriculum_subject_id', '=', 'cs.id')
        ->join('curricula as c', 'cs.curriculum_id', '=', 'c.id')

        ->join('periods as p', 'st.period_id', '=', 'p.id')
        ->join('careers as ca', 'c.career_id', '=', 'ca.id')
        ->join('subjects as m', 'cs.subject_id', '=', 'm.id')

        ->where('e.student_id', $studentId)
        ->where('st.period_id', $periodId)
        ->orderBy('cs.cycle', 'asc')
        ->get()
    );
  }


  /**
   * Create a new Enrollment
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @return App\Models\Enrollment $Enrollment
   */
  public function create(array $data)
  {
    $enrollment = new Enrollment();
    $enrollment->fill($data)->save();

    return $enrollment;
  }

  /**
   * Update an existing Enrollment
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @param App\Models\Enrollment $Enrollment
   *
   * @return boolean
   */
  public function update(array $data, $enrollment = null)
  {
    if (empty($enrollment)) {
      $enrollment = $this->byId($data['id']);
    }

    return $enrollment->update($data);
  }

  /**
   * Delete existing Enrollment
   *
   * @param integer $id
   * 	An Enrollment id
   *
   * @return boolean
   */
  public function delete($id, $enrollment = null)
  {
    if (empty($enrollment)) {
      $enrollment = $this->byId($id);
    }

    return $enrollment->delete();
  }
  public function getStudents($id)
  {


    $query = $this->DB::table('enrollments AS e')
    ->select('e.*')
      ->where('e.code', '=', $id);


      return new Collection(
        $query->get()
      );
  }
}
