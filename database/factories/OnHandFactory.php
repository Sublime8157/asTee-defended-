<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OnHand>
 */
class OnHandFactory extends Factory
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
            // 'userId' => 51,
            'variation_id'=> fake()->numberBetween($min = 1, $max = 4),
            'description'=> fake()->text(),
            'gender' => fake()->numberBetween($min = 1, $max = 3),
            'size'=> fake()->numberBetween($min = 1, $max = 6),
            'price'=> $this->faker->randomNumber(2),
            // 'productStatus' => fake()->numberBetween($min = 1, $max = 4),
            'quantity'=> $this->faker->randomNumber(2),
        ];
    }
}
