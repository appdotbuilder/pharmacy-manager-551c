<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CashBook>
 */
class CashBookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['income', 'expense']);
        $categories = [
            'income' => ['Sales', 'Service Income', 'Interest', 'Other Income'],
            'expense' => ['Rent', 'Utilities', 'Supplies', 'Marketing', 'Staff Salary', 'Other Expenses']
        ];

        return [
            'transaction_date' => fake()->dateTimeBetween('-30 days', 'now'),
            'description' => fake()->sentence(),
            'type' => $type,
            'amount' => fake()->randomFloat(2, 10, 1000),
            'category' => fake()->randomElement($categories[$type]),
            'reference_number' => fake()->optional()->numerify('REF-######'),
            'payment_method' => fake()->randomElement(['cash', 'card', 'transfer', 'check']),
            'notes' => fake()->optional()->paragraph(),
            'user_id' => User::factory(),
        ];
    }
}