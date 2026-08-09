<?php

namespace Database\Factories;

use App\Enums\Gender;
use App\Enums\ShirtSize;
use App\Enums\Variation;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'image_path' => null,
            'description' => fake()->randomElement(['Classic', 'Oversized', 'Vintage wash', 'Boxy fit', 'Ringer'])
                .' '.fake()->randomElement(['cotton', 'jersey', 'pique'])
                .' tee — '.fake()->randomElement(['black', 'bone', 'sand', 'olive', 'rust']),
            'variation' => fake()->randomElement(Variation::cases()),
            'gender' => fake()->randomElement(Gender::cases()),
            'size' => fake()->randomElement(ShirtSize::cases()),
            'price' => fake()->randomElement([349.00, 399.00, 449.00, 499.00, 599.00]),
            'stock' => fake()->numberBetween(0, 40),
        ];
    }
}
