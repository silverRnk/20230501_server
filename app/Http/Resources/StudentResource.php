<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'std_id' => $this->std_ID,
            'std_name' => $this->std_name,
            'std_gender' => $this->std_gender,
            'std_grade' => $this->gradeLevel->name,
            'std_section' => $this->section->name,
            'std_status' => $this->std_status,
            'std_date_of_birth' => $this->std_date_of_birth,
            'parents_phone' => $this->parent->parents_phone_no,
            
            
        ];
    }
}
