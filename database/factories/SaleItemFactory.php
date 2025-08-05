<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SaleItem>
 */
class SaleItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 10);
        $unitPrice = fake()->randomFloat(2, 5, 100);
        $totalPrice = $quantity * $unitPrice;
        $discountAmount = fake()->randomFloat(2, 0, $totalPrice * 0.1);

        return [
            'sale_id' => Sale::factory(),
            'product_id' => Product::factory(),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $totalPrice,
            'discount_amount' => $discountAmount,
            'batch_number' => 'BATCH-' . fake()->numberBetween(1000, 9999),
            'expiry_date' => fake()->optional()->dateTimeBetween('now', '+2 years'),
        ];
    }
}