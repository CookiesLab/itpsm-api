<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicHistory extends Model
{
    use HasFactory;

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
