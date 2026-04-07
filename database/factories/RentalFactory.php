<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Motorcycle;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rental>
 */
class RentalFactory extends Factory
{
    protected $model = Rental::class;

    public function definition(): array
    {
        $start = Carbon::now()->subDays(fake()->numberBetween(7, 90));
        $duration = fake()->numberBetween(1, 5);

        return [
            'customer_id' => Customer::query()->inRandomOrder()->value('id') ?? Customer::factory(),
            'motorcycle_id' => Motorcycle::query()->inRandomOrder()->value('id') ?? Motorcycle::factory(),
            'start_date' => $start->toDateString(),
            'estimated_return_date' => $start->copy()->addDays($duration - 1)->toDateString(),
            'actual_return_date' => null,
            'late_days' => 0,
            'late_fee' => 0,
            'additional_fee' => 0,
            'status' => Rental::STATUS_ONGOING,
            'created_by' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
        ];
    }
}
