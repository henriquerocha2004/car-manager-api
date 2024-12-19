<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'entity_type' => $this->faker->randomElement(['PF', 'PJ']),
            'document' => $this->faker->randomNumber(9, true),
            'document_type' => $this->faker->randomElement(['CPF', 'CNPJ', 'RG']),
            'birth_date' => $this->faker->date(),
        ];
    }
}
