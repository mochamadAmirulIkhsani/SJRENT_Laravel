<?php

namespace Database\Factories;

use App\Models\MotorAvailabilityOverride;
use App\Models\Motorcycle;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MotorAvailabilityOverride>
 */
class MotorAvailabilityOverrideFactory extends Factory
{
    protected $model = MotorAvailabilityOverride::class;

    public function definition(): array
    {
        return [
            'motorcycle_id' => Motorcycle::query()->inRandomOrder()->value('id') ?? Motorcycle::factory(),
            'date' => now()->addDays(fake()->numberBetween(1, 20))->toDateString(),
            'status' => MotorAvailabilityOverride::STATUS_MAINTENANCE,
            'reason' => fake()->randomElement(['Servis rutin', 'Ganti oli', 'Perbaikan rem']),
            'created_by' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
        ];
    }
}
