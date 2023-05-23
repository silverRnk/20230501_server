<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class ParentInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'fathers_name',
        'mothers_name',
        'fathers_occupation',
        'parents_phone_no',
        'parents_email',
        'parents_religion',
        'student_id'
    ];

    public function student(){
        return $this->belongsTo(Student::class);
    }
}
