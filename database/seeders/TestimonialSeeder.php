<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'customer_name' => 'Budi Santoso',
                'rating' => 5,
                'review_text' => 'Pelayanan sangat memuaskan! Motor dalam kondisi bagus dan proses rental sangat mudah. Pasti akan kembali lagi.',
                'is_approved' => true,
                'display_order' => 1,
            ],
            [
                'customer_name' => 'Siti Nurhaliza',
                'rating' => 5,
                'review_text' => 'Harga terjangkau, motor terawat dengan baik. Staff ramah dan responsif. Highly recommended!',
                'is_approved' => true,
                'display_order' => 2,
            ],
            [
                'customer_name' => 'Ahmad Fauzi',
                'rating' => 4,
                'review_text' => 'Motor nyaman dikendarai, harga kompetitif. Layanan antar jemput juga sangat membantu.',
                'is_approved' => true,
                'display_order' => 3,
            ],
            [
                'customer_name' => 'Dewi Lestari',
                'rating' => 5,
                'review_text' => 'Pertama kali rental motor di SJRent dan sangat puas. Prosesnya cepat, tidak ribet. Motor juga bersih dan wangi.',
                'is_approved' => true,
                'display_order' => 4,
            ],
            [
                'customer_name' => 'Rizky Pratama',
                'rating' => 5,
                'review_text' => 'Sudah langganan rental di SJRent. Motor selalu dalam kondisi prima dan harga bersahabat. Top!',
                'is_approved' => true,
                'display_order' => 5,
            ],
            [
                'customer_name' => 'Linda Wijaya',
                'rating' => 4,
                'review_text' => 'Bagus banget! Motor bersih, helm juga disediakan. Pas banget buat jalan-jalan keliling Malang.',
                'is_approved' => true,
                'display_order' => 6,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            \App\Models\Testimonial::create($testimonial);
        }
    }
}
