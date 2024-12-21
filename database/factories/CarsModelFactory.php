<?php

namespace Database\Factories;

use App\Models\CarsModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CarsModel>
 */
class CarsModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'model' => $this->faker->name(),
            'year' => $this->faker->year(),
            'fuel_type' => $this->faker->randomElement(['Gasolina', 'Alcool']),
            'fipe_code' => $this->faker->numberBetween(1000, 99999),
            'fipe_lib_model_code' => $this->faker->numberBetween(1000, 99999),
            'brand_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
