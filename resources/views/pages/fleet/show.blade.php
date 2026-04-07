@extends('layouts.app')

@section('content')
    @php
        $settings = \App\Models\CompanySetting::getInstance();
    @endphp

    <!-- Breadcrumbs -->
    <section class="bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 py-4">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-700 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <a href="{{ route('fleet.index') }}" class="ml-1 text-gray-700 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 md:ml-2">
                                Armada
                            </a>
                        </div>
                    </li>
                    @if($motorcycle->category)
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <a href="{{ route('fleet.index', ['category' => $motorcycle->category->id]) }}" class="ml-1 text-gray-700 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 md:ml-2">
                                {{ $motorcycle->category->name }}
                            </a>
                        </div>
                    </li>
                    @endif
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-1 text-gray-500 dark:text-gray-400 md:ml-2">{{ $motorcycle->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Motorcycle Detail -->
    <section class="py-12 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                <!-- Image Section -->
                <div>
                    <div class="sticky top-24">
                        @if($motorcycle->image)
                            <div class="rounded-2xl overflow-hidden shadow-2xl mb-6">
                                <img src="{{ asset('storage/' . $motorcycle->image) }}" 
                                     alt="{{ $motorcycle->name }}" 
                                     class="w-full h-auto object-cover">
                            </div>
                        @else
                            <div class="rounded-2xl overflow-hidden shadow-2xl mb-6 bg-gray-200 dark:bg-gray-700 aspect-video flex items-center justify-center">
                                <svg class="w-32 h-32 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Additional Info Card -->
                        <div class="glass-card rounded-xl p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Informasi Penting</h3>
                            <ul class="space-y-3 text-gray-600 dark:text-gray-400">
                                <li class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Motor dalam kondisi terawat</span>
                                </li>
                                <li class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Helm dan jas hujan gratis</span>
                                </li>
                                <li class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Antar-jemput tersedia</span>
                                </li>
                                <li class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Proses mudah dan cepat</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Details Section -->
                <div>
                    <!-- Category Badge -->
                    @if($motorcycle->category)
                    <div class="mb-4">
                        <span class="inline-block px-4 py-2 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 rounded-full text-sm font-semibold">
                            {{ $motorcycle->category->name }}
                        </span>
                    </div>
                    @endif
                    
                    <!-- Name -->
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ $motorcycle->name }}
                    </h1>
                    
                    <!-- Status -->
                    <div class="flex items-center space-x-4 mb-6">
                        @if($motorcycle->status === \App\Models\Motorcycle::STATUS_AVAILABLE)
                            <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-green-500 text-white">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Tersedia untuk disewa
                            </span>
                        @elseif($motorcycle->status === \App\Models\Motorcycle::STATUS_RENTED)
                            <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-yellow-500 text-white">
                                Sedang Disewa
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-red-500 text-white">
                                Sedang Maintenance
                            </span>
                        @endif
                    </div>
                    
                    <!-- Pricing -->
                    <div class="glass-card rounded-2xl p-8 mb-8">
                        <div class="flex items-baseline mb-4">
                            <span class="text-5xl font-bold text-gray-900 dark:text-white">
                                Rp {{ number_format($motorcycle->price_per_day, 0, ',', '.') }}
                            </span>
                            <span class="text-2xl text-gray-600 dark:text-gray-400 ml-3">/hari</span>
                        </div>
                        
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                            <p class="text-gray-600 dark:text-gray-400 mb-2">
                                Denda keterlambatan: <span class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($motorcycle->late_fee_per_day, 0, ',', '.') }}/hari</span>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Specifications -->
                    <div class="glass-card rounded-2xl p-8 mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Spesifikasi</h2>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <div class="text-gray-600 dark:text-gray-400 text-sm mb-1">Nomor Polisi</div>
                                <div class="text-gray-900 dark:text-white font-semibold">{{ $motorcycle->plate_number }}</div>
                            </div>
                            <div>
                                <div class="text-gray-600 dark:text-gray-400 text-sm mb-1">Status</div>
                                <div class="text-gray-900 dark:text-white font-semibold">
                                    @if($motorcycle->status === \App\Models\Motorcycle::STATUS_AVAILABLE)
                                        Tersedia
                                    @elseif($motorcycle->status === \App\Models\Motorcycle::STATUS_RENTED)
                                        Sedang Disewa
                                    @else
                                        Maintenance
                                    @endif
                                </div>
                            </div>
                            @if($motorcycle->category)
                            <div>
                                <div class="text-gray-600 dark:text-gray-400 text-sm mb-1">Kategori</div>
                                <div class="text-gray-900 dark:text-white font-semibold">{{ $motorcycle->category->name }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- CTA Buttons -->
                    <div class="space-y-4">
                        @if($settings->whatsapp)
                        <x-cta-button
                            href="{{ $settings->getWhatsAppLink('Halo, saya tertarik untuk rental ' . $motorcycle->name . '. Apakah masih tersedia?') }}"
                            variant="success"
                            size="lg"
                            :full-on-mobile="true"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="w-full rounded-xl shadow-lg hover:shadow-xl"
                        >
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            <span>Sewa Sekarang via WhatsApp</span>
                        </x-cta-button>
                        @endif
                        
                        <x-cta-button
                            href="{{ route('fleet.index') }}"
                            variant="neutral"
                            size="md"
                            :full-on-mobile="true"
                            class="w-full rounded-xl"
                        >
                            Lihat Motor Lainnya
                        </x-cta-button>
                    </div>
                </div>
            </div>
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
