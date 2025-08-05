<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class PharmacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $categories = Category::factory(10)->create();

        // Create products
        $products = collect();
        foreach ($categories as $category) {
            $categoryProducts = Product::factory(random_int(3, 8))->create([
                'category_id' => $category->id
            ]);
            $products = $products->merge($categoryProducts);
        }

        // Create some products with low stock for demo
        $products->random(5)->each(function ($product) {
            $product->update([
                'stock_quantity' => random_int(1, $product->minimum_stock - 1)
            ]);
        });

        // Create customers
        $customers = Customer::factory(50)->create();

        // Create sample sales
        $user = User::first();
        if ($user) {
            for ($i = 0; $i < 20; $i++) {
                $customer = $customers->random();
                $saleProducts = $products->random(random_int(1, 4));
                
                $subtotal = 0;
                $items = [];
                
                foreach ($saleProducts as $product) {
                    $quantity = random_int(1, 5);
                    $price = $product->selling_price;
                    $total = $quantity * $price;
                    $subtotal += $total;
                    
                    $items[] = [
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $price,
                        'total_price' => $total,
                        'discount_amount' => 0,
                    ];
                }

                $sale = Sale::create([
                    'invoice_number' => 'INV-' . date('Ymd') . '-' . str_pad((string)($i + 1), 4, '0', STR_PAD_LEFT),
                    'customer_id' => random_int(0, 1) ? $customer->id : null,
                    'user_id' => $user->id,
                    'subtotal' => $subtotal,
                    'tax_amount' => 0,
                    'discount_amount' => 0,
                    'total_amount' => $subtotal,
                    'paid_amount' => $subtotal,
                    'balance_amount' => 0,
                    'payment_status' => 'paid',
                    'payment_method' => fake()->randomElement(['cash', 'card', 'transfer']),
                    'sale_type' => 'general',
                    'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
                ]);

                foreach ($items as $item) {
                    SaleItem::create(array_merge($item, ['sale_id' => $sale->id]));
                }
            }
        }
    }
}