@php
    $settings = \App\Models\CompanySetting::getInstance();
@endphp

<header x-data="{ 
    mobileMenuOpen: false, 
    scrolled: false,
    themeDropdownOpen: false
}" 
        x-init="window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 20 })"
        :class="scrolled ? 'glass-header shadow-lg' : 'bg-white/90 dark:bg-gray-800/90'"
        class="sticky top-0 z-40 w-full backdrop-blur-md transition-all duration-300">
    
    <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    @if($settings->logo)
                        <img src="{{ asset('storage/' . $settings->logo) }}" 
                             alt="{{ $settings->company_name }}" 
                             class="h-12 w-auto transform group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="flex items-center space-x-2">
                            <svg class="w-10 h-10 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                            </svg>
                            <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $settings->company_name }}</span>
                        </div>
                    @endif
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="{{ route('home') }}" 
                   class="nav-link {{ request()->routeIs('home') ? 'nav-link-active' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('fleet.index') }}" 
                   class="nav-link {{ request()->routeIs('fleet.*') ? 'nav-link-active' : '' }}">
                    Armada
                </a>
                <a href="{{ route('about') }}" 
                   class="nav-link {{ request()->routeIs('about') ? 'nav-link-active' : '' }}">
                    Tentang
                </a>
                <a href="{{ route('services') }}" 
                   class="nav-link {{ request()->routeIs('services') ? 'nav-link-active' : '' }}">
                    Layanan
                </a>
                <a href="{{ route('contact') }}" 
                   class="nav-link {{ request()->routeIs('contact') ? 'nav-link-active' : '' }}">
                    Kontak
                </a>
            </div>

            <!-- Right Side: Theme Toggle & CTA -->
            <div class="hidden md:flex items-center space-x-4">
                
                <!-- Theme Toggle Dropdown -->
                <div class="relative" @click.away="themeDropdownOpen = false">
                    <button @click="themeDropdownOpen = !themeDropdownOpen"
                            class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                            aria-label="Toggle theme">
                        <svg x-show="theme === 'light'" class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <svg x-show="theme === 'dark'" class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg x-show="theme === 'system'" class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </button>
                    
                    <div x-show="themeDropdownOpen"
                         x-transition
                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 py-1">
                        <button @click="setTheme('light'); themeDropdownOpen = false"
                                class="w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center space-x-2"
                                :class="theme === 'light' ? 'text-blue-600 dark:text-blue-400' : ''">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span>Terang</span>
                        </button>
                        <button @click="setTheme('dark'); themeDropdownOpen = false"
                                class="w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center space-x-2"
                                :class="theme === 'dark' ? 'text-blue-600 dark:text-blue-400' : ''">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                            <span>Gelap</span>
                        </button>
                        <button @click="setTheme('system'); themeDropdownOpen = false"
                                class="w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center space-x-2"
                                :class="theme === 'system' ? 'text-blue-600 dark:text-blue-400' : ''">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>Sistem</span>
                        </button>
                    </div>
                </div>

                <!-- WhatsApp CTA Button -->
                @if($settings->whatsapp)
                <a href="{{ $settings->getWhatsAppLink() }}" 
                   target="_blank"
                   rel="noopener noreferrer"
                   class="btn-magnetic bg-green-500 hover:bg-green-600 text-white px-6 py-2.5 rounded-lg font-medium flex items-center space-x-2 shadow-md hover:shadow-lg transition-all duration-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    <span>Hubungi Kami</span>
                </a>
                @endif
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                        aria-label="Toggle mobile menu">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition
             class="md:hidden pb-4 space-y-2">
            <a href="{{ route('home') }}" 
               class="block px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('home') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : '' }}">
                Beranda
            </a>
            <a href="{{ route('fleet.index') }}" 
               class="block px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('fleet.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : '' }}">
                Armada
            </a>
            <a href="{{ route('about') }}" 
               class="block px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('about') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : '' }}">
                Tentang
            </a>
            <a href="{{ route('services') }}" 
               class="block px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('services') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : '' }}">
                Layanan
            </a>
            <a href="{{ route('contact') }}" 
               class="block px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('contact') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : '' }}">
                Kontak
            </a>
            
            @if($settings->whatsapp)
            <a href="{{ $settings->getWhatsAppLink() }}" 
               target="_blank"
               rel="noopener noreferrer"
               class="block bg-green-500 hover:bg-green-600 text-white px-4 py-2.5 rounded-lg font-medium text-center">
                Hubungi via WhatsApp
            </a>
            @endif
        </div>
    </nav>
</header>

@push('styles')
<style>
    .glass-header {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    
    .dark .glass-header {
        background: rgba(31, 41, 55, 0.8);
    }
    
    .nav-link {
        @apply px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300 font-medium;
    }
    
    .nav-link-active {
        @apply bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400;
    }
    
    .btn-magnetic {
        position: relative;
        transform-style: preserve-3d;
    }
    
    .btn-magnetic:hover {
        transform: translateY(-2px);
    }
</style>
@endpush
