<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\StudentResource;
use App\Http\Resources\GradeLevelsResource;
use App\Models\GradeLevel;
class StudentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => StudentResource::collection($this->collection),
            'grade_levels' => GradeLevelsResource::collection(
                GradeLevel::query()->orderBy('level', 'asc')->get()
            ),
            
        ];
    }
}
