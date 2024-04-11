<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Models\User>
 */
class customerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fname' => fake()->firstName(),     
            'mname' => fake()->name(),      
            'lname' => fake()->lastName(),
           
            'email' => fake()->unique()->safeEmail(),
            'birthday' => $date($format = 'Y-m-d', $max = 'now') ,
            'username' => fake()->unique()->userName(),

            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
          
            
        ];
    }
}
