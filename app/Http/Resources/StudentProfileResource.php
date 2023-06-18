<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class StudentProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $img_path = explode('/', $this->std_photo);

        return [
            'id_number' => $this->std_ID,
            'name' => $this->std_name,
            'gender'=> $this->std_gender,
            'profile_img'=>'/student_img/'.$img_path[1],
            'date_of_birth' => $this->std_date_of_birth,
            'religion' => $this->std_religion,
            'e_mail' => $this->std_email,
            'fathers_name' => $this->parent->fathers_name,
            'mothers_name' => $this->parent->mothers_name,
            'father_occupation' => $this->parent->fathers_occupation,
            'admission_date' => $this->created_at,
            'class' => $this->gradeLevel->name,
            'section' => $this->section->name,
            'status' => $this->std_status
        ];
    }
}
