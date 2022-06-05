<?php
/**
 * @file
 * UserInterface
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserInterface extends RepositoryInterface {

    /**
	* Get an user by Email
	*
	* @param string $email
	*
	* @return Illuminate\Database\Eloquent\Model;
	*/
    public function byEmail($email);

	/**
	* Update an User password
	*
	* @param array $data
	* 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
	*
	* @param string $referenceTable
  * @param string $referenceId;
	*
	* @return boolean
	*/
    public function resetPassword(array $data, $referenceTable, $referenceId);
}
