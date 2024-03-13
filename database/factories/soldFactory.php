<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class soldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'productId' => 2,
        'userId' => fake()->numberBetween($min = 4, $max = 48),
        'amount' => $this->faker->randomNumber(2),
        'quantity' => $this->faker->randomNumber(2), 
        'created_at'=> fake()->dateTime($max = 'now'),
        ];
    }
}
