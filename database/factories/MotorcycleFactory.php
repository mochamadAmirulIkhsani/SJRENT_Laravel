<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Motorcycle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Motorcycle>
 */
class MotorcycleFactory extends Factory
{
    protected $model = Motorcycle::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::query()->inRandomOrder()->value('id') ?? Category::factory(),
            'name' => fake()->randomElement(['Honda Vario', 'Yamaha NMAX', 'Suzuki Nex', 'Honda Beat', 'Yamaha Mio']) . ' ' . fake()->numberBetween(110, 160),
            'plate_number' => 'B ' . fake()->unique()->numberBetween(1000, 9999) . ' ' . strtoupper(fake()->bothify('??')),
            'price_per_day' => fake()->numberBetween(75000, 180000),
            'late_fee_per_day' => fake()->numberBetween(25000, 60000),
            'image' => null,
            'status' => Motorcycle::STATUS_AVAILABLE,
        ];
    }
}
