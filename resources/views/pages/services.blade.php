@extends('layouts.app')

@section('content')
    @php
        $settings = \App\Models\CompanySetting::getInstance();
        $faqs = $settings->faqs ?? [];
    @endphp

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 dark:from-blue-900 dark:to-blue-950 py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Layanan Kami</h1>
            <p class="text-xl text-blue-100">Paket rental motor yang fleksibel sesuai kebutuhan Anda</p>
        </div>
    </section>

    <!-- Rental Packages Section -->
    <section class="py-20 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-gray-900 dark:text-white mb-16">Paket Rental</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="glass-card p-8 rounded-2xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="text-blue-600 dark:text-blue-400 font-bold text-sm mb-2">PAKET JAM</div>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Harian</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Rental per hari, cocok untuk jalan-jalan sehari</p>
                    <div class="space-y-3">
                        <div class="flex items-center text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>24 jam penuh</span>
                        </div>
                        <div class="flex items-center text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Helm & jas hujan</span>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-8 rounded-2xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-blue-500">
                    <div class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-bold inline-block mb-2">POPULER</div>
                    <div class="text-blue-600 dark:text-blue-400 font-bold text-sm mb-2">PAKET MINGGUAN</div>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Mingguan</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Rental per minggu dengan harga lebih hemat</p>
                    <div class="space-y-3">
                        <div class="flex items-center text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>7 hari</span>
                        </div>
                        <div class="flex items-center text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Diskon spesial</span>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-8 rounded-2xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="text-blue-600 dark:text-blue-400 font-bold text-sm mb-2">PAKET BULANAN</div>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Bulanan</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Rental jangka panjang dengan harga terbaik</p>
                    <div class="space-y-3">
                        <div class="flex items-center text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>30 hari</span>
                        </div>
                        <div class="flex items-center text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Free service</span>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-8 rounded-2xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="text-blue-600 dark:text-blue-400 font-bold text-sm mb-2">PAKET CUSTOM</div>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Custom</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Sesuaikan durasi rental dengan kebutuhan</p>
                    <div class="space-y-3">
                        <div class="flex items-center text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Durasi fleksibel</span>
                        </div>
                        <div class="flex items-center text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Harga nego</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Requirements Section -->
    <section class="py-20 bg-gray-50 dark:bg-gray-800">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-4xl font-bold text-center text-gray-900 dark:text-white mb-16">Syarat Rental</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">KTP Asli</h3>
                            <p class="text-gray-600 dark:text-gray-400">Kartu identitas asli (bukan fotokopi) untuk verifikasi</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">SIM C Aktif</h3>
                            <p class="text-gray-600 dark:text-gray-400">Surat Izin Mengemudi kategori C yang masih berlaku</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Uang Deposit</h3>
                            <p class="text-gray-600 dark:text-gray-400">Deposit akan dikembalikan setelah motor dikembalikan</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Minimal Usia 17 Tahun</h3>
                            <p class="text-gray-600 dark:text-gray-400">Penyewa harus berusia minimal 17 tahun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    @if(count($faqs) > 0)
    <section class="py-20 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-4xl font-bold text-center text-gray-900 dark:text-white mb-16">
                    Pertanyaan yang Sering Diajukan
                </h2>
                
                <div x-data="{ activeIndex: null }" class="space-y-4">
                    @foreach($faqs as $index => $faq)
                    <div class="glass-card rounded-lg overflow-hidden">
                        <button @click="activeIndex = activeIndex === {{ $index }} ? null : {{ $index }}"
                                class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $faq['question'] }}</span>
                            <svg :class="activeIndex === {{ $index }} ? 'rotate-180' : ''" 
                                 class="w-5 h-5 text-gray-500 transition-transform" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="activeIndex === {{ $index }}" 
                             x-transition
                             class="px-6 pb-5 text-gray-600 dark:text-gray-400">
                            {{ $faq['answer'] }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    @push('styles')
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .dark .glass-card {
            background: rgba(31, 41, 55, 0.8);
            border: 1px solid rgba(75, 85, 99, 0.2);
        }
    </style>
    @endpush
@endsection
