<?php

namespace Database\Factories;

use App\Models\Rental;
use App\Models\RentalPayment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RentalPayment>
 */
class RentalPaymentFactory extends Factory
{
    protected $model = RentalPayment::class;

    public function definition(): array
    {
        return [
            'rental_id' => Rental::query()->inRandomOrder()->value('id') ?? Rental::factory(),
            'amount' => fake()->numberBetween(50000, 400000),
            'payment_type' => fake()->randomElement([
                RentalPayment::TYPE_RENT_DOWN_PAYMENT,
                RentalPayment::TYPE_RENT_FULL,
                RentalPayment::TYPE_LATE_FEE,
                RentalPayment::TYPE_ADDITIONAL_FEE,
            ]),
            'payment_date' => now()->subDays(fake()->numberBetween(0, 60)),
            'notes' => fake()->optional()->sentence(),
            'created_by' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
        ];
    }
}
