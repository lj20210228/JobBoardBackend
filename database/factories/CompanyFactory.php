<?php

namespace Database\Factories;

use App\Http\Service\GeocodingService;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'address' => $this->faker->randomElement([
                'Belgrade, Serbia',
                'Novi Sad, Serbia',
                'Niš, Serbia',
                'Zagreb, Croatia',
            ]),
            'phone' => $this->faker->phoneNumber,
            'description' => $this->faker->catchPhrase,
            'user_id' => null,
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function ($company) {
            $geo = app(GeocodingService::class)->geocode($company->address);

            if ($geo) {
                $company->updateQuietly([
                    'latitude' => $geo['lat'],
                    'longitude' => $geo['lon'],
                ]);
            }
        });
    }
}
