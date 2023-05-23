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
            'std_id' => $this->std_ID,
            'std_name' => $this->std_name,
            'std_gender'=> $this->std_gender,
            'std_photo'=>'/student_img/'.$img_path[1],
            'std_dob' => $this->std_date_of_birth,
            'std_religion' => $this->std_religion,
            'std_email' => $this->std_email,
            'fathers_name' => $this->parent->fathers_name,
            'mothers_name' => $this->parent->mothers_name,
            'fathers_occupation' => $this->parent->fathers_occupation,
            'admission_date' => $this->created_at,
            'std_status' => $this->std_status
        ];
    }
}
