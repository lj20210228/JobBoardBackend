<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $alumniUser = User::where('role', 'alumni')->inRandomOrder()->first();

        return [
            'user_id' => $alumniUser ? $alumniUser->id : User::factory()->create(['role' => 'alumni'])->id,
            'company_id' => Company::inRandomOrder()->first()->id,
            'comment' => $this->faker->sentence(),
            'rating' => $this->faker->numberBetween(1, 5),
        ];

    }
}
