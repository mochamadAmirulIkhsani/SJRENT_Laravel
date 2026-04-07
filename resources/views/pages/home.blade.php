@extends('layouts.app')

@section('content')
    @php
        $whyChooseUs = $settings->why_choose_us ?? [
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
        ];
    @endphp

    <!-- Hero Section -->
    <section class="relative min-h-[520px] sm:min-h-[600px] flex items-center justify-center overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900 dark:from-blue-900 dark:via-blue-950 dark:to-gray-900">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center text-white" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
                <div x-show="show" x-transition.duration.700ms>
                    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold mb-4 sm:mb-6 leading-tight">
                        {{ $settings->company_name }}
                    </h1>
                    <p class="text-lg sm:text-xl md:text-2xl lg:text-3xl mb-3 sm:mb-4 text-blue-100">
                        {{ $settings->tagline }}
                    </p>
                    <p class="text-base sm:text-lg md:text-xl mb-6 sm:mb-8 text-blue-100 max-w-2xl mx-auto">
                        Rental motor terpercaya di Malang dengan harga terjangkau dan layanan terbaik
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center items-center w-full max-w-md sm:max-w-none mx-auto">
                        @if($settings->whatsapp)
                        <x-cta-button
                            href="{{ $settings->getWhatsAppLink() }}"
                            variant="success"
                            size="md"
                            :full-on-mobile="true"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn-magnetic"
                        >
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            <span>Hubungi via WhatsApp</span>
                        </x-cta-button>
                        @endif
                        <x-cta-button
                            href="{{ route('fleet.index') }}"
                            variant="light"
                            size="md"
                            :full-on-mobile="true"
                        >
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <span>Lihat Armada</span>
                        </x-cta-button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-16 sm:py-20 bg-white dark:bg-gray-900" x-data="{ inView: false }" x-intersect="inView = true">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-header
                title="Mengapa Memilih Kami?"
                description="Kami berkomitmen memberikan layanan rental motor terbaik di Malang"
            />
            
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8">
                @foreach($whyChooseUs as $index => $item)
                <div x-show="inView" 
                     x-transition.delay.{{ $index * 100 }}ms
                     class="glass-card p-4 sm:p-6 lg:p-8 rounded-xl sm:rounded-2xl hover:shadow-xl lg:hover:shadow-2xl transition-all duration-300 transform md:hover:-translate-y-2">
                    <div class="bg-blue-100 dark:bg-blue-900 w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16 rounded-xl flex items-center justify-center mb-4 sm:mb-6">
                        @if($item['icon'] === 'shield-check')
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        @elseif($item['icon'] === 'currency-dollar')
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        @elseif($item['icon'] === 'clock')
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        @else
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        @endif
                    </div>
                    <h3 class="text-base sm:text-lg lg:text-xl font-bold text-gray-900 dark:text-white mb-2 sm:mb-3 leading-tight">
                        {{ $item['title'] }}
                    </h3>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 leading-relaxed">
                        {{ $item['description'] }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Motorcycles Section -->
    <section class="py-16 sm:py-20 bg-gray-50 dark:bg-gray-800">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-header
                title="Armada Motor Kami"
                description="Pilihan motor berkualitas untuk kebutuhan rental Anda"
                description-class="text-base sm:text-xl text-gray-600 dark:text-gray-400"
            />
            
            @if($motorcycles->count() > 0)
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8">
                @foreach($motorcycles as $motorcycle)
                    <x-motorcycle-card :motorcycle="$motorcycle" />
                @endforeach
            </div>
            
            <div class="text-center mt-10 sm:mt-12">
                <x-cta-button href="{{ route('fleet.index') }}" variant="primary" size="sm">
                    <span>Lihat Semua Armada</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </x-cta-button>
            </div>
            @else
            <div class="text-center py-12">
                <p class="text-gray-500 dark:text-gray-400 text-lg">
                    Motor akan segera tersedia. Hubungi kami untuk informasi lebih lanjut.
                </p>
            </div>
            @endif
        </div>
    </section>

    <!-- Gallery Section -->
    @if($galleries->count() > 0)
    <section class="py-16 sm:py-20 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-header
                title="Gallery Kami"
                description="Dokumentasi armada, fasilitas, dan kegiatan pelayanan kami"
            />

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($galleries as $gallery)
                <figure class="group overflow-hidden rounded-xl sm:rounded-2xl shadow-md sm:shadow-lg bg-gray-100 dark:bg-gray-800">
                    <img
                        src="{{ asset('storage/' . $gallery->image_path) }}"
                        alt="{{ $gallery->alt_text ?: $gallery->title }}"
                        loading="lazy"
                        class="h-36 sm:h-48 lg:h-64 w-full object-cover transition-transform duration-500 group-hover:scale-105"
                    >
                    <figcaption class="p-3 sm:p-4">
                        <p class="text-[11px] sm:text-sm uppercase tracking-wide text-blue-600 dark:text-blue-400 font-semibold line-clamp-1">
                            {{ ucfirst($gallery->category) }}
                        </p>
                        <h3 class="mt-1 text-sm sm:text-lg font-bold text-gray-900 dark:text-white line-clamp-1">
                            {{ $gallery->title }}
                        </h3>
                        @if($gallery->description)
                        <p class="mt-1.5 sm:mt-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                            {{ $gallery->description }}
                        </p>
                        @endif
                    </figcaption>
                </figure>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Testimonials Section -->
    @if($testimonials->count() > 0)
    <section class="py-16 sm:py-20 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-header
                title="Apa Kata Pelanggan"
                description="Testimoni dari pelanggan yang puas dengan layanan kami"
                description-class="text-base sm:text-xl text-gray-600 dark:text-gray-400"
            />
            
            <x-testimonial-slider :testimonials="$testimonials" />
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="py-16 sm:py-20 bg-gradient-to-r from-blue-600 to-blue-800 dark:from-blue-900 dark:to-blue-950">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4 sm:mb-6 leading-tight">
                Siap Untuk Rental Motor?
            </h2>
            <p class="text-base sm:text-xl text-blue-100 mb-6 sm:mb-8 max-w-2xl mx-auto">
                Hubungi kami sekarang untuk mendapatkan penawaran terbaik dan motor pilihan Anda
            </p>
            @if($settings->whatsapp)
            <x-cta-button
                href="{{ $settings->getWhatsAppLink() }}"
                variant="success"
                size="lg"
                target="_blank"
                rel="noopener noreferrer"
                class="shadow-xl hover:shadow-2xl"
            >
                <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                <span>Chat Sekarang</span>
            </x-cta-button>
            @endif
        </div>
    </section>

    @push('styles')
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .dark .glass-card {
            background: rgba(31, 41, 55, 0.8);
            border: 1px solid rgba(75, 85, 99, 0.2);
        }
    </style>
    @endpush
@endsection
