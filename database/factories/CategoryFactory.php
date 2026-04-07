<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(['Matic', 'Sport', 'Bebek', 'Listrik']) . ' ' . fake()->unique()->numberBetween(1, 99),
            'description' => fake()->sentence(),
        ];
    }
}
