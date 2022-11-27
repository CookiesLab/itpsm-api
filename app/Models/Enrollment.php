<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'final_score',
        'is_approved',
        'enrollment',
        'curriculum_subject_id',

        'code',
        'student_id',

    ];

    protected function setKeysForSaveQuery($query)
    {
      $query
          ->where('student_id', '=', $this->getAttribute('student_id'))
          ->where('curriculum_subject_id', '=', $this->getAttribute('curriculum_subject_id'))
          ->where('code', '=', $this->getAttribute('code'));

      return $query;
    }
}
