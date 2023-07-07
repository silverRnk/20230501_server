<?php

namespace Database\Seeders;

use App\Models\Credential;
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

        $data1['name'] = "Mr Admin";
        $data1['privilege'] = 1;
        $data1['email'] = 'admin@email.com';
        $data1['password'] = bcrypt('changeme');

        Admin::create($data1);

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
            'fathers_occupation' => 'Store Owner',
            'parents_phone_no' => fake()->phoneNumber(),
            'parents_email' => fake()->unique()->safeEmail(),
            'parents_religion' => 'baptist',
            'student_id' => $stdId
        ];
        ParentModel::create($parent);

        $birthCert = [
            'std_ID' => $stdId,
            'credential_type' => 'birth_cert',
            'file_name' => 'Test_Credentials.pdf',
            'file_path' => 'student_credentials/Test_Credentials.pdf'
        ];

        Credential::create($birthCert);

        $form137 = [
            'std_ID' => $stdId,
            'credential_type' => 'form_137',
            'file_name' => 'Test_Credentials.pdf',
            'file_path' => 'student_credentials/Test_Credentials.pdf'
        ];

        Credential::create($form137);

    }
}
