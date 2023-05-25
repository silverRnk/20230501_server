<?php

namespace App\Http\Resources;

use App\Models\GradeLevel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;


class TeachersCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'teachers' => TeacherResource::collection($this->collection),
            'grade_levels' => GradeLevelsResource::collection(
                GradeLevel::query()->orderBy('level', 'asc')->get()
            )
        ];
    }
}
