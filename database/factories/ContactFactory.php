<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'postal_code' => fake()->postcode(),
            'state'       => 'SP',
            'city'        => 'São Paulo',
            'district'    => fake()->word(),
            'address'     => fake()->streetAddress(),
            'number'      => fake()->buildingNumber(),
            'name'        => fake()->name(),
            'email'       => fake()->unique()->safeEmail(),
            'phone'       => fake()->phoneNumber(),
        ];
    }
}
