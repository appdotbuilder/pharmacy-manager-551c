<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->optional()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->optional()->address(),
            'date_of_birth' => fake()->optional()->date('Y-m-d', '-18 years'),
            'gender' => fake()->optional()->randomElement(['male', 'female', 'other']),
            'credit_limit' => fake()->randomFloat(2, 0, 1000),
            'current_balance' => fake()->randomFloat(2, 0, 500),
            'is_active' => true,
        ];
    }
}