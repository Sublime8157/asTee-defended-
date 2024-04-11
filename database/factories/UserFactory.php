<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ? string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    
        $faker = Faker::create();

        return [
            'fname' => $faker->firstName(),
            'mname' => $faker->name(),
            'lname' => $faker->lastName(),
            'email' => $faker->unique()->safeEmail(),
            // 'birthday' => $faker->date($format = 'Y-m-d', $max = 'now'),
            'username' => $faker->unique()->userName(),
            'address' => 'philippines',
            'userStatus' => $faker->numberBetween($min = 1, $max = 2),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            // 'created_at' => $faker->dateTimeThisCentury()
        ];

    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
