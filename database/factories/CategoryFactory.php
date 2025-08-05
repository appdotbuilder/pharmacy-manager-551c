<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Antibiotics',
            'Pain Relief',
            'Vitamins',
            'Supplements',
            'Cardiovascular',
            'Diabetes',
            'Respiratory',
            'Dermatology',
            'Gastrointestinal',
            'Neurology'
        ];

        $name = fake()->randomElement($categories);

        return [
            'name' => $name,
            'code' => strtoupper(substr($name, 0, 3)) . fake()->numberBetween(100, 999),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}