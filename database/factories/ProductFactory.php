<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $products = [
            'Paracetamol 500mg',
            'Ibuprofen 400mg',
            'Amoxicillin 250mg',
            'Vitamin C 1000mg',
            'Omega-3 Fish Oil',
            'Metformin 500mg',
            'Atorvastatin 20mg',
            'Salbutamol Inhaler',
            'Hydrocortisone Cream',
            'Omeprazole 20mg'
        ];

        $basePrice = fake()->randomFloat(2, 5, 100);
        $markupPercentage = fake()->randomFloat(2, 10, 50);
        $sellingPrice = $basePrice * (1 + $markupPercentage / 100);

        return [
            'name' => fake()->randomElement($products),
            'sku' => 'SKU-' . fake()->unique()->randomNumber(6),
            'barcode' => fake()->ean13(),
            'category_id' => Category::factory(),
            'description' => fake()->paragraph(),
            'base_price' => $basePrice,
            'selling_price' => $sellingPrice,
            'markup_percentage' => $markupPercentage,
            'stock_quantity' => fake()->numberBetween(0, 500),
            'minimum_stock' => fake()->numberBetween(10, 50),
            'unit' => fake()->randomElement(['pcs', 'tablets', 'bottles', 'boxes', 'tubes']),
            'requires_prescription' => fake()->boolean(30),
            'expiry_date' => fake()->dateTimeBetween('now', '+2 years'),
            'batch_number' => 'BATCH-' . fake()->numberBetween(1000, 9999),
            'is_active' => true,
        ];
    }
}