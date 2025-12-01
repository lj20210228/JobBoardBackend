<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Informacione tehnologije (IT)',
            'Ekonomija i finansije',
            'Marketing i PR',
            'Ljudski resursi (HR)',
            'Pravo i administracija',
            'Medicina i farmacija',
            'Građevinarstvo i arhitektura',
            'Mašinstvo',
            'Dizajn i multimedija',
            'Obrazovanje i jezici'
        ];

        return [
            'name' => $this->faker->randomElement($categories)
        ];
    }
}
