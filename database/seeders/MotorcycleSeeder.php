<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MotorcycleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = \App\Models\Category::all();
        
        $motorcycles = [
            [
                'category_id' => $categories->where('name', 'Matic')->first()->id,
                'name' => 'Honda Vario 125',
                'plate_number' => 'N 1234 AB',
                'price_per_day' => 75000,
                'late_fee_per_day' => 25000,
                'status' => 'available',
            ],
            [
                'category_id' => $categories->where('name', 'Matic')->first()->id,
                'name' => 'Yamaha NMax',
                'plate_number' => 'N 5678 CD',
                'price_per_day' => 90000,
                'late_fee_per_day' => 30000,
                'status' => 'available',
            ],
            [
                'category_id' => $categories->where('name', 'Sport')->first()->id,
                'name' => 'Honda CBR 150R',
                'plate_number' => 'N 9012 EF',
                'price_per_day' => 120000,
                'late_fee_per_day' => 40000,
                'status' => 'available',
            ],
            [
                'category_id' => $categories->where('name', 'Matic')->first()->id,
                'name' => 'Honda Beat Street',
                'plate_number' => 'N 3456 GH',
                'price_per_day' => 65000,
                'late_fee_per_day' => 20000,
                'status' => 'available',
            ],
            [
                'category_id' => $categories->where('name', 'Bebek')->first()->id,
                'name' => 'Honda Supra X 125',
                'plate_number' => 'N 7890 IJ',
                'price_per_day' => 60000,
                'late_fee_per_day' => 20000,
                'status' => 'available',
            ],
            [
                'category_id' => $categories->where('name', 'Matic')->first()->id,
                'name' => 'Yamaha Aerox 155',
                'plate_number' => 'N 2345 KL',
                'price_per_day' => 100000,
                'late_fee_per_day' => 35000,
                'status' => 'available',
            ],
        ];

        foreach ($motorcycles as $motorcycle) {
            \App\Models\Motorcycle::create($motorcycle);
        }
    }
}
