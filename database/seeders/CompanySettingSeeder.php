<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\CompanySetting::create([
            'company_name' => 'SJRent',
            'tagline' => 'Rental Motor Terpercaya di Malang',
            'description' => 'SJRent adalah penyedia layanan rental motor terpercaya di Malang, Jawa Timur. Kami menyediakan berbagai jenis motor dengan harga terjangkau dan pelayanan terbaik. Dengan armada motor yang terawat dan proses rental yang mudah, SJRent siap melayani kebutuhan transportasi Anda.',
            'address' => 'Jl. Soekarno Hatta No. 123, Malang, Jawa Timur 65141',
            'phone' => '0341-123456',
            'email' => 'info@sjrent.com',
            'whatsapp' => '081234567890',
            'coordinates_lat' => -7.9666,
            'coordinates_lng' => 112.6326,
            'business_hours' => [
                'senin-jumat' => '08:00 - 20:00',
                'sabtu-minggu' => '08:00 - 18:00'
            ],
            'social_media' => [
                'instagram' => 'https://instagram.com/sjrent',
                'facebook' => 'https://facebook.com/sjrent',
                'whatsapp_business' => 'https://wa.me/6281234567890'
            ],
            'meta_title' => 'SJRent - Rental Motor Malang Terpercaya & Murah',
            'meta_description' => 'Rental motor murah dan terpercaya di Malang. Tersedia berbagai jenis motor matic, sport, bebek dengan harga terjangkau. Proses mudah, motor terawat. Hubungi sekarang!',
            'meta_keywords' => 'rental motor malang, sewa motor malang, rental motor murah malang, sewa motor matic malang',
            'why_choose_us' => [
                [
                    'icon' => 'shield-check',
                    'title' => 'Terpercaya & Aman',
                    'description' => 'Motor terawat dengan baik dan asuransi lengkap untuk keamanan Anda'
                ],
                [
                    'icon' => 'currency-dollar',
                    'title' => 'Harga Terjangkau',
                    'description' => 'Harga rental kompetitif dengan berbagai paket menarik'
                ],
                [
                    'icon' => 'clock',
                    'title' => 'Layanan 24/7',
                    'description' => 'Siap melayani kebutuhan rental motor Anda kapan saja'
                ],
                [
                    'icon' => 'check-circle',
                    'title' => 'Proses Mudah',
                    'description' => 'Persyaratan simple dan proses rental yang cepat'
                ]
            ],
            'faqs' => [
                [
                    'question' => 'Apa saja syarat rental motor?',
                    'answer' => 'KTP asli, SIM C aktif, dan uang deposit sesuai ketentuan.'
                ],
                [
                    'question' => 'Apakah tersedia layanan antar-jemput?',
                    'answer' => 'Ya, kami menyediakan layanan antar-jemput motor ke lokasi Anda.'
                ],
                [
                    'question' => 'Bagaimana jika motor mengalami kerusakan?',
                    'answer' => 'Hubungi kami segera. Kerusakan normal akan kami tanggung, kerusakan akibat kelalaian pengguna dikenakan biaya perbaikan.'
                ]
            ]
        ]);
    }
}
