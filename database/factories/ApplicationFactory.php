<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::where('role','student')->inRandomOrder()->first()->id,
            'job_id' => Job::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(['pending','accepted','rejected']),
            'linkedinUrl' => $this->faker->url,
            'resume_url' => $this->faker->url,
        ];
    }
}
