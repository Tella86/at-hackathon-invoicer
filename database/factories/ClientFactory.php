<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'email' => fake()->unique()->safeEmail(),
            // Generate a phone number in the format Africa's Talking expects
            'phone' => '+2547' . fake()->numerify('########'),
        ];
    }
}
