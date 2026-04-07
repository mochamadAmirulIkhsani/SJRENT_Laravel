@props(['motorcycle'])

<div class="glass-card rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
    <!-- Image -->
    <div class="relative h-56 overflow-hidden bg-gray-200 dark:bg-gray-700">
        @if($motorcycle->image)
            <img src="{{ asset('storage/' . $motorcycle->image) }}" 
                 alt="{{ $motorcycle->name }}" 
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                 loading="lazy">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <svg class="w-20 h-20 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                </svg>
            </div>
        @endif
        
        <!-- Status Badge -->
        <div class="absolute top-4 right-4">
            @if($motorcycle->status === \App\Models\Motorcycle::STATUS_AVAILABLE)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-500 text-white shadow-lg">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Tersedia
                </span>
            @elseif($motorcycle->status === \App\Models\Motorcycle::STATUS_RENTED)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-500 text-white shadow-lg">
                    Disewa
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-500 text-white shadow-lg">
                    Maintenance
                </span>
            @endif
        </div>
    </div>
    
    <!-- Content -->
    <div class="p-6">
        <!-- Category -->
        @if($motorcycle->category)
        <div class="text-sm text-blue-600 dark:text-blue-400 font-semibold mb-2">
            {{ $motorcycle->category->name }}
        </div>
        @endif
        
        <!-- Name -->
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 line-clamp-2">
            {{ $motorcycle->name }}
        </h3>
        
        <!-- Price -->
        <div class="flex items-baseline mb-4">
            <span class="text-3xl font-bold text-gray-900 dark:text-white">
                Rp {{ number_format($motorcycle->price_per_day, 0, ',', '.') }}
            </span>
            <span class="text-gray-600 dark:text-gray-400 ml-2">/hari</span>
        </div>
        
        <!-- Button -->
        <a href="{{ route('fleet.show', $motorcycle->slug) }}" 
           class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
            Lihat Detail
        </a>
    </div>
</div>

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
