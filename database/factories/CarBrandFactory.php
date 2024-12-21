<?php

namespace Database\Factories;

use App\Models\CarBrand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CarBrand>
 */
class CarBrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand' => $this->faker->word(),
            'fipe_code' => $this->faker->numberBetween(1000, 9999),
            'url_logo' => $this->faker->imageUrl(),
        ];
    }
}
