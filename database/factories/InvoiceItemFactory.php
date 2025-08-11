<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'description' => fake()->sentence(4),
            'quantity' => fake()->numberBetween(1, 5),
            'unit_price' => fake()->randomFloat(2, 1000, 20000), // 2 decimal places, between 1000 and 20000
        ];
    }
}
