<?php

/**
 * @file
 * EloquentUser
 *
 * All code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

namespace App\Repositories\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;

class EloquentUser implements UserInterface {

	/**
	* User
	*
	* @var App\Models\User;
	*
	*/
	protected $User;

	public function __construct(Model $User)
	{
		$this->User = $User;
	}

    /**
    * Retrieve list of users
    *
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function searchTableRowsWithPagination($count = false, $limit = null, $offset = null, $filter = null, $sortColumn = null, $sortOrder = null)
    {
        $query = $this->User->select('id', 'name', 'username', 'email', 'phone_number', 'birth_date', 'created_at', 'updated_at');

        if(!empty($filter))
        {
          $query->where(function($dbQuery) use ($filter)
          {
            foreach (['name', 'username', 'email'] as $key => $value)
            {
                $dbQuery->orWhere($value, 'like', '%' . str_replace(' ', '%', $filter) . '%');
                //$dbQuery->orwhereRaw('lower(`' . $value . '`) LIKE ? ',['%' . strtolower(str_replace(' ', '%', $filter)) . '%']);
            }
          });
        }

        if(!empty($sortColumn) && !empty($sortOrder))
        {
          $query->orderBy($sortColumn, $sortOrder);
        }

        if($count)
        {
            return $query->count();
        }

        if(!empty($limit))
        {
            $query->take($limit);
        }

        if(!empty($offset) && $offset != 0)
        {
            $query->skip($offset);
        }
        return new Collection(
            $query->get()
        );
    }

    /**
     * Get an user by id
    *
    * @param  int $id
    *
    * @return App\Models\User
    */
    public function byId($id)
    {
        return $this->User->find($id);
    }

    /**
    * Retrieve User by email
    *
    * @param  string email
    *
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function byEmail($email, $databaseConnectionName = null)
    {
        return $this->User->where('email', '=', $email)->get();
    }


    /**
     * Create a new User
    *
    * @param array $data
    * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
    *
    * @return App\Models\User $User
    */
    public function create(array $data)
    {
        $user = new User();
        $user->fill($data)->save();

        return $user;
    }

    /**
     * Update an existing User
    *
    * @param array $data
    * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
    *
    * @param App\Models\User $user
    *
    * @return boolean
    */
    public function update(array $data, $user = null)
    {
        if(empty($user))
        {
            $user = $this->byId($data['id']);
        }

        return $user->update($data);
    }

    /**
     * Delete existing User
    *
    * @param integer $id
    * 	An user id
    *
    * @return boolean
    */
    public function delete($id)
    {
        return $this->User->destroy($id);
    }

    /**
     * Update an User password
     *
    * @param array $data
    * 	An array as follows: array('field0'=>$field0, 'field1'=>$field1);
    *
    * @param integer $referenceTable
    * @param integer $referenceId
    *
    * @return boolean
    */
    public function resetPassword(array $data, $referenceTable, $referenceId) {
        $user = $this->User
        ->where('system_reference_table', $referenceTable)
        ->where('system_reference_id', $referenceId)
        ->first();

        if(empty($user))
        {
            return false;
        }

        return $user->update($data);
    }

}
