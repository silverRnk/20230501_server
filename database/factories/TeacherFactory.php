<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
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

        return [
            'name' => fake()->name(),
            'gender' => $gender,
            'date_of_birth' => fake()->date(),
            'religion' => fake()->randomElement([
                'Baptist',
                'Catholic'
            ]),
            'email' => fake()->unique()->email(),
            'phone_no' => fake()->phoneNumber(),
            'password' => bcrypt('changeme'),
            'advisory_class' => null,
            'profile_img' => fake()->randomElement(
                $gender === 'male'?
                $profileImgLinksMale:
                $profileImgLinksFemale
            )
        ];
    }
}
