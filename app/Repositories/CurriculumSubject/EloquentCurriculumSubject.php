<?php

/**
 * @file
 * EloquentCurriculumSubject
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\CurriculumSubject;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\CurriculumSubject;

class EloquentCurriculumSubject implements CurriculumSubjectInterface
{

  /**
   * CurriculumSubject
   *
   * @var App\Models\CurriculumSubject;
   *
   */
  protected $CurriculumSubject;

  /**
   * DB
   *
   * @var Illuminate\Support\Facades\DB;
   *
   */
  protected $DB;

  public function __construct(Model $CurriculumSubject, DB $DB)
  {
    $this->CurriculumSubject = $CurriculumSubject;
    $this->DB = $DB;
  }

  /**
   * Retrieve list of CurriculumSubjects
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null, $customQuery = null)
  {
    $query = $this->DB::table('curriculum_subjects AS cs')
      ->select(
        'cs.id',
        'cs.uv',
        'cs.cycle',
        's.id AS subject_id',
        's.name AS subject_name',
        's.code AS subject_code'
      )
      ->join('subjects as s', 'cs.subject_id', '=', 's.id');

    if (!empty($customQuery)) {
      $query->whereNested(function ($dbQuery) use ($customQuery) {
        foreach ($customQuery as $statement) {

          if($statement['op'] == 'is not in')
          {
            $dbQuery->whereNotIn($statement['field'], explode(',',$statement['data']));
            continue;
          }

          if($statement['op'] == 'is null')
          {
            $dbQuery->whereNull($statement['field']);
            continue;
          }

          if($statement['op'] == 'is not null')
          {
            $dbQuery->whereNotNull($statement['field']);
            continue;
          }

          $dbQuery->where($statement['field'], $statement['op'], $statement['data']);
        }
      });
    }

    if (!empty($filter)) {
      $query->where(function ($dbQuery) use ($filter) {
        foreach (['s.name', 's.code'] as $key => $value) {
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

  /**
   * Get an CurriculumSubject by id
   *
   * @param  int $id
   *
   * @return App\Models\CurriculumSubject
   */
  public function byId($id)
  {
    return $this->CurriculumSubject->find($id);
  }

  /**
   * Get subjects by curriculum id
   *
   * @param integer $id
   *
   * @return boolean
   */
  public function getSubjectsByCurriculumId($curriculumId)
  {
    return new Collection(
      $this->DB::table('curriculum_subjects AS cs')
        ->select(
          'cs.id',
          'cs.uv',
          'cs.cycle',
          's.id AS subject_id',
          's.name AS subject_name',
          's.code AS subject_code'
        )
        ->join('subjects as s', 'cs.subject_id', '=', 's.id')
        ->where('cs.curriculum_id', $curriculumId)
        ->orderBy('cs.id', 'asc')
        ->get()
    );
  }

  /**
   * Create a new CurriculumSubject
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @return App\Models\CurriculumSubject $CurriculumSubject
   */
  public function create(array $data)
  {
    $curriculumSubject = new CurriculumSubject();
    $curriculumSubject->fill($data)->save();

    return $curriculumSubject;
  }

  /**
   * Update an existing CurriculumSubject
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @param App\Models\CurriculumSubject $CurriculumSubject
   *
   * @return boolean
   */
  public function update(array $data, $curriculumSubject = null)
  {
    if (empty($curriculumSubject)) {
      $curriculumSubject = $this->byId($data['id']);
    }

    return $curriculumSubject->update($data);
  }

  /**
   * Delete existing CurriculumSubject
   *
   * @param integer $id
   * 	An CurriculumSubject id
   *
   * @return boolean
   */
  public function delete($id)
  {
    return $this->CurriculumSubject->destroy($id);
  }
}
