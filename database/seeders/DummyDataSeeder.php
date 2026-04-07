<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\MotorAvailabilityOverride;
use App\Models\Motorcycle;
use App\Models\Rental;
use App\Models\RentalPayment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $staffUsers = User::query()->get();
        $createdBy = (int) ($staffUsers->first()?->id ?? 1);

        if (Category::query()->count() < 4) {
            foreach ([
                ['name' => 'Matic', 'description' => 'Motor matic harian'],
                ['name' => 'Sport', 'description' => 'Motor sport untuk touring'],
                ['name' => 'Bebek', 'description' => 'Motor bebek irit bahan bakar'],
                ['name' => 'Listrik', 'description' => 'Motor listrik ramah lingkungan'],
            ] as $row) {
                Category::query()->firstOrCreate(['name' => $row['name']], $row);
            }
        }

        if (Motorcycle::query()->count() < 20) {
            Motorcycle::factory()->count(20 - Motorcycle::query()->count())->create();
        }

        if (Customer::query()->count() < 40) {
            Customer::factory()->count(40 - Customer::query()->count())->create();
        }

        $motorcycles = Motorcycle::query()->get();
        $customers = Customer::query()->get();

        // Mark some motorcycles as maintenance by default.
        $maintenanceIds = $motorcycles->shuffle()->take(3)->pluck('id');
        Motorcycle::query()->whereIn('id', $maintenanceIds)->update(['status' => Motorcycle::STATUS_MAINTENANCE]);

        $availableMotorcycles = Motorcycle::query()
            ->whereNotIn('id', $maintenanceIds)
            ->get();

        // Completed rentals (historical data)
        for ($i = 0; $i < 60; $i++) {
            $motorcycle = $availableMotorcycles->random();
            $customer = $customers->random();
            $staff = $staffUsers->random();

            $start = Carbon::now()->subDays(random_int(20, 120));
            $duration = random_int(1, 5);
            $estimated = $start->copy()->addDays($duration - 1);
            $lateDays = random_int(0, 3);
            $actual = $estimated->copy()->addDays($lateDays);
            $lateFee = $lateDays * (float) $motorcycle->late_fee_per_day;
            $additional = random_int(0, 1) ? random_int(10000, 50000) : 0;

            $rental = Rental::query()->create([
                'customer_id' => $customer->id,
                'motorcycle_id' => $motorcycle->id,
                'start_date' => $start->toDateString(),
                'estimated_return_date' => $estimated->toDateString(),
                'actual_return_date' => $actual->toDateString(),
                'late_days' => $lateDays,
                'late_fee' => $lateFee,
                'additional_fee' => $additional,
                'status' => Rental::STATUS_COMPLETED,
                'created_by' => $staff->id,
            ]);

            RentalPayment::query()->create([
                'rental_id' => $rental->id,
                'amount' => (float) $rental->grand_total,
                'payment_type' => RentalPayment::TYPE_RENT_FULL,
                'payment_date' => $start->copy()->addHours(1),
                'notes' => 'Pembayaran otomatis dummy',
                'created_by' => $staff->id,
            ]);
        }

        // Ongoing rentals without overlap by using distinct motorcycles.
        $ongoingMotorcycles = $availableMotorcycles->shuffle()->take(8);
        foreach ($ongoingMotorcycles as $motorcycle) {
            $customer = $customers->random();
            $staff = $staffUsers->random();
            $start = Carbon::now()->subDays(random_int(0, 2));
            $estimated = $start->copy()->addDays(random_int(1, 4));

            $rental = Rental::query()->create([
                'customer_id' => $customer->id,
                'motorcycle_id' => $motorcycle->id,
                'start_date' => $start->toDateString(),
                'estimated_return_date' => $estimated->toDateString(),
                'actual_return_date' => null,
                'late_days' => 0,
                'late_fee' => 0,
                'additional_fee' => 0,
                'status' => Rental::STATUS_ONGOING,
                'created_by' => $staff->id,
            ]);

            RentalPayment::query()->create([
                'rental_id' => $rental->id,
                'amount' => max(50000, (float) $rental->grand_total * 0.5),
                'payment_type' => RentalPayment::TYPE_RENT_DOWN_PAYMENT,
                'payment_date' => now(),
                'notes' => 'DP dummy',
                'created_by' => $staff->id,
            ]);
        }

        // Cancelled rentals for analytics variety.
        for ($i = 0; $i < 10; $i++) {
            $motorcycle = $availableMotorcycles->random();
            $customer = $customers->random();
            $staff = $staffUsers->random();
            $start = Carbon::now()->subDays(random_int(5, 30));
            $estimated = $start->copy()->addDays(random_int(1, 3));

            Rental::query()->create([
                'customer_id' => $customer->id,
                'motorcycle_id' => $motorcycle->id,
                'start_date' => $start->toDateString(),
                'estimated_return_date' => $estimated->toDateString(),
                'actual_return_date' => null,
                'late_days' => 0,
                'late_fee' => 0,
                'additional_fee' => 0,
                'status' => Rental::STATUS_CANCELLED,
                'created_by' => $staff->id,
            ]);
        }

        // Maintenance overrides in upcoming days.
        $futureMaintenance = $availableMotorcycles->shuffle()->take(10);
        foreach ($futureMaintenance as $motorcycle) {
            $date = now()->addDays(random_int(1, 20))->toDateString();
            MotorAvailabilityOverride::query()->firstOrCreate([
                'motorcycle_id' => $motorcycle->id,
                'date' => $date,
            ], [
                'status' => MotorAvailabilityOverride::STATUS_MAINTENANCE,
                'reason' => 'Jadwal maintenance dummy',
                'created_by' => $createdBy,
            ]);
        }

        Motorcycle::query()->get()->each->syncRentalStatus();
    }
}
