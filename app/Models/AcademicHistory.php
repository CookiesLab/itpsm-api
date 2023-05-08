<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AcademicHistory extends Model
{
    use HasFactory,SoftDeletes;
    /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
    protected $table = 'academic_history';
    protected $fillable = [
        'subject_id',
        'student_id',
        'curriculum_id',
        'totalScore',
        'IsEquivalence',
        'year',
        'period'
      ];
}
