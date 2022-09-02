<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'quota',
        'schedule',
        'teacher_id',
        'curriculum_subject_id',
        'period_id'
    ];

    protected function setKeysForSaveQuery($query)
    {
      $query
          ->where('curriculum_subject_id', '=', $this->getAttribute('curriculum_subject_id'))
          ->where('period_id', '=', $this->getAttribute('period_id'))
          ->where('code', '=', $this->getAttribute('code'));

      return $query;
    }
}
