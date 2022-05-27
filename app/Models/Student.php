<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
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
        'email',
        'institutional_email',
        'birth_date',
        'address',
        'phone_number',
        'home_phone_number',
        'gender',
        'relationship',
        'status',
        'blood_type',
        'mother_name',
        'mother_phone_number',
        'father_name',
        'father_phone_number',
        'emergency_contact_name',
        'emergency_contact_phone',
        'diseases',
        'allergies',
        'entry_date',
        'entry_period',
        'date_high_school_degree',
        'municipality_id',
        'department_id',
        'country_id',
        'status_id',
        'is_user_created',
        'is_live_in_rural_area',
        'is_private_high_school',
        'high_school_name',
        'high_school_option',
    ];
}
