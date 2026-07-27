<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
        return [
            'nama_produk' => fake()->words(2, true),
            'harga' => fake()->numberBetween(10000, 500000),
            'stok' => fake()->numberBetween(1, 100),
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}
