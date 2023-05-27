<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Student;
use App\Models\User;
use App\Models\ParentInfo as ParentModel;
use Illuminate\Support\Facades\Log;

class DefaultSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data['name'] = 'Patrick';
        $data['privilege'] = 1;
        $data['email'] = 'patdi.x@xmail.com';
        $data['password'] = bcrypt('changeme');

        Admin::create($data);

        $student = [
            'std_name' => 'Diana Bautista',
            'std_email' => 'diana@exmail.com',
            'std_gender' => 'female' ,
            'password' => bcrypt('changeme'),
            'std_photo' => "student_profile_imgs/test_female_img1.jpg",
            'std_date_of_birth' => fake()->dateTime(),
            'std_religion' => 'baptist',
            'std_status' => 'old',
            'tchr_Id' => 1,
            'grade_level_id' => 'nrs',
            'section_id' => 1,
            'school_Id' => 1
        ];

        $stdId = Student::create($student)->std_ID;

        $parent = [
            'fathers_name' => fake()->name('male'),
            'mothers_name' => fake()->name('female'),
            'fathers_occupation' => 'Plumber',
            'parents_phone_no' => fake()->phoneNumber(),
            'parents_email' => fake()->unique()->safeEmail(),
            'parents_religion' => 'baptist',
            'student_id' => $stdId
        ];


        ParentModel::create($parent);


    }
}
