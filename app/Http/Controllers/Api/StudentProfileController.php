<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentProfileCollection;
use App\Models\Student;
use Illuminate\Http\Request;


class StudentProfileController extends Controller
{
    public function profile(string $id){
        // dd(Student::where('std_ID', $id)->get());

        return new StudentProfileCollection(
            Student::where('std_ID', $id)->get()
        );
    }
}
