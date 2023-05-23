<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradeLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grade_levels = [
           'nrs' => ['Nursery', 1],
           'kdr' => ['Kinder', 2],
           'grd-1' => ['Grade-1', 3],
           'grd-2' => ['Grade-2', 4],
           'grd-3' =>['Grade-3', 5],
           'grd-4' => ['Grade-4', 6],
           'grd-6' => ['Grade-5', 7],
           'grd-7' => ['Grade-6', 8]
        ];

        foreach($grade_levels as $uuid => [$name, $level]){
            DB::table('grade_levels')->insert(
                [
                    'uuid' => $uuid,
                    'level' => $level,
                    'name' => $name
                ]
            );
        }

        foreach($grade_levels as $uuid => $name){
            for($i=0;$i<3;$i++){
                DB::table('class_sections')->insert(
                    [
                      'grade_level_id' => $uuid,
                      'name' => fake()->unique()->firstName()
                    ]
                    );
            }
            
        }
        
    }
}
