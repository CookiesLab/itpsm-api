<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'carnet',
        'name',
        'last_name',
        'birth_date',
        'nit',
        'dui',
        'isss_number',
        'nup_number',
        'email',
        'institutional_email',
        'entry_date',
        'is_user_created',
        'genre',
        'address',
        'phone_number',
        'home_phone_number',
        'municipality_id',
        'department_id',
        'country_id',
        'status_id'
    ];
}
