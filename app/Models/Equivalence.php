<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Equivalence extends Model
{
  use HasFactory,SoftDeletes;
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $table = 'equivalence';
  protected $fillable = [
    'AcademicHistory_id',
    'institution',
    'IsinnerEquivalence',
    'subject_id',
    'subjectname'
  ];
}
