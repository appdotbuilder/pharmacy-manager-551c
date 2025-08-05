<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 10, 500);
        $taxAmount = $subtotal * 0.1; // 10% tax
        $discountAmount = fake()->randomFloat(2, 0, $subtotal * 0.1);
        $totalAmount = $subtotal + $taxAmount - $discountAmount;
        $paidAmount = fake()->boolean(80) ? $totalAmount : fake()->randomFloat(2, 0, $totalAmount);
        $balanceAmount = $totalAmount - $paidAmount;

        return [
            'invoice_number' => 'INV-' . date('Ymd') . '-' . fake()->unique()->numberBetween(1000, 9999),
            'customer_id' => fake()->optional(70)->randomElement(Customer::pluck('id')->toArray()),
            'user_id' => User::factory(),
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'balance_amount' => $balanceAmount,
            'payment_status' => $balanceAmount > 0 ? ($paidAmount > 0 ? 'partial' : 'unpaid') : 'paid',
            'payment_method' => fake()->randomElement(['cash', 'card', 'transfer', 'credit']),
            'sale_type' => fake()->randomElement(['general', 'prescription', 'cost_plus_markup']),
            'is_return' => fake()->boolean(5),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}