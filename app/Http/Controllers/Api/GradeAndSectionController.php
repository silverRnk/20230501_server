<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GradeLevelsResource;
use App\Models\GradeLevel;
use Illuminate\Http\Request;

class GradeAndSectionController extends Controller
{
    public function gradesAndSections(){
        return GradeLevelsResource::collection(
            GradeLevel::query()->orderBy('level', 'asc')->get()
        );
    }

}
