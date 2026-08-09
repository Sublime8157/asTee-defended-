<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'fname' => fake()->firstName(),
            'mname' => fake()->firstName(),
            'lname' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'birthday' => fake()->date('Y-m-d', '-18 years'),
            'username' => fake()->unique()->userName(),
            'address' => fake()->streetAddress().', Manila',
            'contact' => '09'.fake()->numerify('#########'),
            'profile' => null,
            'email_verified_at' => now(),
            // Was `userStatus => numberBetween(1, 2)`, so a random half of the
            // seeded customers were blocked for no reason.
            'blocked_at' => null,
            'id_verified_at' => null,
            'password' => static::$password ??= 'Password123!',
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => ['email_verified_at' => null]);
    }

    public function blocked(): static
    {
        return $this->state(fn (array $attributes) => ['blocked_at' => now()]);
    }

    public function idVerified(): static
    {
        return $this->state(fn (array $attributes) => ['id_verified_at' => now()]);
    }
}
