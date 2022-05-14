<?php
/**
 * @file
 * MunicipalityInterface
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\Municipality;

use App\Repositories\RepositoryInterface;

interface MunicipalityInterface extends RepositoryInterface {

/**
   * Retrieve list of Municipalities by DepartmentId
  *
  *
  * @return Illuminate\Database\Eloquent\Collection
  */
  public function getMunicipalitiesByDepartmentId($id);

}
