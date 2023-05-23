<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ParentInfo>
 */
class ParentInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fathers_name' => fake()->name('male'),
            'mothers_name' => fake()->name('female'),
            'fathers_occupation' => 'Plumber',
            'parents_phone_no' => fake()->phoneNumber(),
            'parents_email' => fake()->unique()->safeEmail(),
            'parents_religion' => 'baptist'
        ];
    }
}
