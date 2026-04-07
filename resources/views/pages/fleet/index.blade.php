@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 dark:from-blue-900 dark:to-blue-950 py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Armada Motor Kami
            </h1>
            <p class="text-xl text-blue-100">
                Pilih motor favorit Anda dari koleksi lengkap kami
            </p>
        </div>
    </section>

    <!-- Search and Filter Section -->
    <section class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 py-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('fleet.index') }}" class="flex flex-col md:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari motor..." 
                               class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Category Filter -->
                <div class="md:w-64">
                    <select name="category" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" 
                        class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-300">
                    Filter
                </button>
                
                @if(request()->hasAny(['search', 'category']))
                <a href="{{ route('fleet.index') }}" 
                   class="px-8 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white font-semibold rounded-lg transition-colors duration-300">
                    Reset
                </a>
                @endif
            </form>
        </div>
    </section>

    <!-- Motorcycles Grid -->
    <section class="py-12 bg-gray-50 dark:bg-gray-800">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            @if($motorcycles->count() > 0)
                <!-- Results Count -->
                <div class="mb-8">
                    <p class="text-gray-600 dark:text-gray-400">
                        Menampilkan {{ $motorcycles->count() }} dari {{ $motorcycles->total() }} motor
                    </p>
                </div>
                
                <!-- Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($motorcycles as $motorcycle)
                        <x-motorcycle-card :motorcycle="$motorcycle" />
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-12">
                    {{ $motorcycles->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <svg class="w-24 h-24 mx-auto text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        Tidak Ada Motor Ditemukan
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Coba ubah filter atau kata kunci pencarian Anda
                    </p>
                    <a href="{{ route('fleet.index') }}" 
                       class="inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-300">
                        <span>Lihat Semua Motor</span>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-blue-600 dark:bg-blue-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                Tidak Menemukan Motor Yang Anda Cari?
            </h2>
            <p class="text-xl text-blue-100 mb-8">
                Hubungi kami untuk informasi lebih lanjut tentang ketersediaan motor
            </p>
            @php
                $settings = \App\Models\CompanySetting::getInstance();
            @endphp
            @if($settings->whatsapp)
            <a href="{{ $settings->getWhatsAppLink('Halo, saya ingin menanyakan ketersediaan motor.') }}" 
               target="_blank"
               rel="noopener noreferrer"
               class="inline-flex items-center space-x-3 bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-lg font-semibold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                <span>Hubungi Kami</span>
            </a>
            @endif
        </div>
    </section>
@endsection
