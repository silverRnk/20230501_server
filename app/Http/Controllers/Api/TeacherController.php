<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddTeacherRequest;
use App\Http\Resources\TeachersCollection;
use App\Http\Resources\ViewTeacherCollection;
use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function all(){

        return new TeachersCollection(
            Teacher::query()
            ->orderBy('id', 'desc')
            ->paginate(10)
        );

    }

    public function add(AddTeacherRequest $request){
        //TODO
        $data = $request->validated();

        
    }

    public function view(string $id){
        
        return new ViewTeacherCollection(
            Teacher::where('id', $id)->get()
        );
    }
}
