@extends('layouts.app')

@section('content')
    @php
        $settings = \App\Models\CompanySetting::getInstance();
    @endphp

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 dark:from-blue-900 dark:to-blue-950 py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">Tentang {{ $settings->company_name }}</h1>
            <p class="text-xl md:text-2xl text-blue-100">{{ $settings->tagline }}</p>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="py-20 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-8">Cerita Kami</h2>
                <div class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed space-y-4">
                    <p>{{ $settings->description }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="py-20 bg-gray-50 dark:bg-gray-800">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="glass-card p-10 rounded-2xl">
                    <div class="bg-blue-100 dark:bg-blue-900 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Misi Kami</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Menyediakan layanan rental motor berkualitas tinggi dengan harga terjangkau, 
                        serta memberikan pengalaman terbaik bagi setiap pelanggan kami.
                    </p>
                </div>
                
                <div class="glass-card p-10 rounded-2xl">
                    <div class="bg-green-100 dark:bg-green-900 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Visi Kami</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Menjadi penyedia layanan rental motor terdepan di Malang yang dipercaya oleh 
                        masyarakat dengan standar pelayanan terbaik.
                    </p>
                </div>
            </div>
        </div>
    </section>

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
