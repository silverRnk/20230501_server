<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ClassSectionResource;

class GradeLevelsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'grade_level_id' => $this->uuid,
            'level' => $this->level,
            'grade_level' => $this->name,
            'sections' => ClassSectionResource::collection(
                $this->sections)
        ];
    }
}
