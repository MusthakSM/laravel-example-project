<?php

namespace Database\Factories;

use App\Models\Employer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // define the attributes that you have to populate with fake data;
            'title' => fake()->jobTitle(),
            'employer_id' => Employer::factory(),
            'salary' => '$50,000'
        ];
    }
}
