<?php

namespace Database\Seeders;

use App\Models\ParentInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // for($i=0;$i<=50;$i++){

        //     $student = Student::factory()
        //     ->create();

        //     ParentInfo::factory()
        //         ->for($student)
        //         ->create();

            
        // }

        Student::factory()
            ->has(ParentInfo::factory()->count(1), 'parent')
            ->count(30)
            ->create();

        
    }
}
