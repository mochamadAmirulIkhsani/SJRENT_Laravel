<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (['super_admin', 'admin', 'cashier'] as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $user = User::query()->firstOrCreate([
            'email' => 'admin@sjrent.local',
        ], [
            'name' => 'SJRent Super Admin',
            'password' => 'password',
        ]);

        $user->assignRole('super_admin');

        $admin = User::query()->firstOrCreate([
            'email' => 'admin2@sjrent.local',
        ], [
            'name' => 'SJRent Admin',
            'password' => 'password',
        ]);
        $admin->assignRole('admin');

        $cashier = User::query()->firstOrCreate([
            'email' => 'cashier@sjrent.local',
        ], [
            'name' => 'SJRent Cashier',
            'password' => 'password',
        ]);
        $cashier->assignRole('cashier');

        $this->call([
            CompanySettingSeeder::class,
            CategorySeeder::class,
            MotorcycleSeeder::class,
            TestimonialSeeder::class,
            DummyDataSeeder::class,
        ]);
    }
}
