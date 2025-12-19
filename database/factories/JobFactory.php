<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Company;
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
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->text,
            'company_id' => Company::inRandomOrder()->first()->id,
            'deadline' => $this->faker->dateTimeBetween('now','+2 months'),
            'salary' => $this->faker->numberBetween(800,3000),
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}
