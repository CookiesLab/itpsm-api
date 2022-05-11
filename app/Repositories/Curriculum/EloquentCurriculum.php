<?php

/**
 * @file
 * EloquentCurriculum
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\Curriculum;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Curriculum;

class EloquentCurriculum implements CurriculumInterface
{

  /**
   * Curriculum
   *
   * @var App\Models\Curriculum;
   *
   */
  protected $Curriculum;

  /**
   * DB
   *
   * @var Illuminate\Support\Facades\DB;
   *
   */
  protected $DB;

  public function __construct(Model $Curriculum, DB $DB)
  {
    $this->Curriculum = $Curriculum;
    $this->DB = $DB;
  }

  /**
   * Retrieve list of Curricula
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null)
  {
    $query = $this->DB::table('curricula AS c')
      ->select(
        'c.id',
        'c.name',
        'c.year',
        'c.is_active',
        'ca.id AS career_id',
        'ca.name AS career_name'
      )
      ->join('careers as ca', 'c.career_id', '=', 'ca.id');

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
   * @return App\Models\Curriculum
   */
  public function byId($id)
  {
    return $this->Curriculum->find($id);
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
    $curriculum = new Curriculum();
    $curriculum->fill($data)->save();

    return $curriculum;
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
