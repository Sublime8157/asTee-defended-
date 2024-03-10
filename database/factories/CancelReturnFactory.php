<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\products>
 */
class CancelReturnFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image_path' => 'p1.jpg',
            'variation_id' => fake()->numberBetween($min = 1, $max = 4),
            'description'=> fake()->text($maxNbChars = 200),
            'gender' => fake()->numberBetween($min = 1, $max = 3),
            'size' => fake()->numberBetween($min = 1, $max = 6),
            'userId'=> fake()->numberBetween($min = 500, $max = 1000),
            'price' => $this->faker->randomNumber(2),
            'quantity' => $this->faker->randomNumber(2),
            'reason' => fake()->numberBetween($min = 1, $max = 7),
            // 'productStatus' => fake()->numberBetween($min = 1, $max = 4),
        ];
    }
}
