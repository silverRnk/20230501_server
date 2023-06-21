<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if(!empty($this->profile_img)){
            $imgName = explode('/', $this->profile_img)[1];
            $imgLink = '/teacher_img/'.$imgName;
        }else{
            $imgLink = '';
        }

        return [
            'teacher_id' => $this->uuid,
            'teacher_name' => $this->name,
            'teacher_gender' => $this->gender,
            'teacher_date_of_birth' => $this->date_of_birth, 
            'teacher_address' => $this->address,
            'teacher_religion' => $this->religion,
            'teacher_email' => $this->email,
            'teacher_phone' => $this->phone_no,
            'teacher_advisory_class' => $this->advisory_class,
            'teacher_admission_date'  => $this->admission_date,
            'teacher_profile_img' => $imgLink,
        ];
    }
}
