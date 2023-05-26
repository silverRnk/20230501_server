<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ClassSection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        $profileImgLinksMale = [
            "student_profile_imgs/test_male_img1.jpg",
            "student_profile_imgs/test_male_img2.jpg",
        ];

        $profileImgLinksFemale = [
            "student_profile_imgs/test_female_img1.jpg",
            "student_profile_imgs/test_female_img2.jpg",
        ];
        $gender = fake()->randomElement(['male', 'female']);


        $section = ClassSection::inRandomOrder()->first();

        $status = fake()
        ->randomElement(['old', 'transferee', 'new']);

        return [
            'std_name' => fake()
            ->firstName($gender).' '.fake()->lastName(),
            'std_email' => fake()->unique()->safeEmail(),
            'std_gender' => $gender ,
            'password' => bcrypt('changeme'),
            'std_photo' => fake()->randomElement(
                $gender === 'male'?
                $profileImgLinksMale:
                $profileImgLinksFemale
            ),
            'std_date_of_birth' => fake()->dateTime(),
            'std_religion' => 'baptist',
            'std_status' => $status,
            'tchr_Id' => 1,
            'grade_level_id' => $section->grade_level_id,
            'section_id' => $section->id,
            'school_Id' => 1
        ];
    }
}
