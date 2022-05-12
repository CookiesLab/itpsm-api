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
        'period_id',
        'code',
        'student_id',
        'teacher_id'
    ];
}
