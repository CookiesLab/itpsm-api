<?php

/**
 * @file
 * EloquentPrerequisite
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\Prerequisite;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Prerequisite;

class EloquentPrerequisite implements PrerequisiteInterface
{

  /**
   * Prerequisite
   *
   * @var App\Models\Prerequisite;
   *
   */
  protected $Prerequisite;

  /**
   * DB
   *
   * @var Illuminate\Support\Facades\DB;
   *
   */
  protected $DB;

  public function __construct(Model $Prerequisite, DB $DB)
  {
    $this->Prerequisite = $Prerequisite;
    $this->DB = $DB;
  }

  /**
   * Retrieve list of Prerequisites
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null)
  {
    $query = $this->DB::table('prerequisites AS p')
      ->select(
        'p.curriculum_subject_id',
        'p.prerequisite_id',
        's.id AS subject_id',
        's.name AS subject_name',
        's.code AS subject_code',
        'c.id AS curricula_id',
        'c.name AS curricula_name',
        'c.year AS curricula_year',
        'c.is_active AS curricula_is_active'
      )
      ->join('curriculum_subjects as cs', 'p.curriculum_subject_id', '=', 'cs.id')
      ->join('subjects as s', 'cs.subject_id', '=', 's.id')
      ->join('curricula as c', 'cs.curriculum_id', '=', 'c.id');


    if (!empty($filter)) {
      $query->where(function ($dbQuery) use ($filter) {
        foreach (['name', 'email'] as $key => $value) {
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
   * Get Prerequisites by subjectId
   *
   * @param  int $id
   *
   * @return App\Models\Collection
   */
  public function byId($id)
  {
    return new Collection(
      $this->DB::table('prerequisites AS p')
        ->join('curriculum_subjects as cs', 'p.curriculum_subject_id', '=', 'cs.id')
        ->join('subjects as s', 'cs.subject_id', '=', 's.id')
        ->where('p.curriculum_subject_id', '=', $id)
        ->get(array(
          'p.*',
          's.id AS subject_id',
          's.code AS subject_code',
          's.name AS subject_name',
        ))
    );
  }

  /**
   * Create a new Prerequisite
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @return App\Models\Prerequisite $Prerequisite
   */
  public function create(array $data)
  {
    $prerequisite = new Prerequisite();
    $prerequisite->fill($data)->save();

    return $prerequisite;
  }

  /**
   * Update an existing Prerequisite
   *
   * @param array $data
   * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
   *
   * @param App\Models\Prerequisite $Prerequisite
   *
   * @return boolean
   */
  public function update(array $data, $prerequisite = null)
  {
    if (empty($prerequisite)) {
      $prerequisite = $this->byId($data['id']);
    }

    return $prerequisite->update($data);
  }

  /**
   * Delete existing Prerequisite
   *
   * @param integer $id
   * 	An Prerequisite id
   *
   * @return boolean
   */
  public function delete($id)
  {
    return $this->Prerequisite->destroy($id);
  }
}
