<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollee extends Model
{
    use HasFactory;

    protected $fillable = [
         'name',
         'date_of_birth',
         'gender',
         'address',
         'place_of_birth',
         'phone_no',
         'enrollee_type',
         'prev_school',
         'email',
         'password',
         'grade_level_id',
         'fathers_name',
         'fathers_occupation',
         'mothers_name',
         'mothers_occupation',
         'guardians_phone_no',
         'guardians_email',
         'good_moral',
         'form_138',
         'birth_cert',
         'validated'
    ];

    protected $hidden = [
        'password'
    ];

    
}