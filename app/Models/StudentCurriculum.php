<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCurriculum extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'cum',
      'entry_year',
      'student_id',
      'curriculum_id',
      'scholarship_id',
      'graduation_year',
      'scholarship_rate',
      'status',
      'level',
      'uv','uv_total'
    ];

    protected function setKeysForSaveQuery($query)
    {
      $query
          ->where('student_id', '=', $this->getAttribute('student_id'))
          ->where('curriculum_id', '=', $this->getAttribute('curriculum_id'));

      return $query;
    }
}
