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

        return [
            'teacher_id' => $this->id,
            'teacher_name' => $this->name,
            'teacher_gender' => $this->gender,
            'teacher_class' => $this->advisory_class,
            'teacher_addr' => $this->date_of_birth,
            'teacher_phone' => $this->phone_no,
            'teacher_admission_date'  => $this->admission_date
        ];
    }
}
