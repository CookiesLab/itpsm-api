<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreEvaluation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'evaluation_id',
        'score'
    ];

    protected function setKeysForSaveQuery($query)
    {
      $query
          ->where('student_id', '=', $this->getAttribute('student_id'))
          ->where('evaluation_id', '=', $this->getAttribute('evaluation_id'));

      return $query;
    }
}
