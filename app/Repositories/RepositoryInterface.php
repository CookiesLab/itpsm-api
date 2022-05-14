<?php
/**
 * @file
 * RepositoryInterface.
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface {

  /**
   * Retrieve list of user
  *
  *
  * @return Illuminate\Database\Eloquent\Collection
  */
  public function searchTableRowsWithPagination();

  /**
	* Get an user by id
	*
	* @param  int $id
	*
	* @return Illuminate\Database\Eloquent\Model;
	*/
    public function byId($id);

	/**
	* Create a new User
	*
	* @param array $data
	* 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
	*
	* @return Illuminate\Database\Eloquent\Model;
	*/
	public function create(array  $data);

	/**
	* Update an existing User
	*
	* @param array $data
	* 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
	*
	* @param Illuminate\Database\Eloquent\Model;
	*
	* @return boolean
	*/
	public function update(array $data, $model = null);

	/**
	* Delete existing User
	*
	* @param integer $id
	* 	An user id
	*
	* @return boolean
	*/
	public function delete(array $id);
}
