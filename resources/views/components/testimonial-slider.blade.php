@props(['testimonials'])

<div x-data="testimonialSlider()" class="relative">
    <!-- Slider Container -->
    <div class="overflow-hidden">
        <div class="flex transition-transform duration-500 ease-out" 
             :style="`transform: translateX(-${currentSlide * 100}%)`">
            @foreach($testimonials as $testimonial)
            <div class="w-full flex-shrink-0 px-4">
                <div class="glass-card rounded-2xl p-8 md:p-12 max-w-4xl mx-auto">
                    <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8">
                        <!-- Customer Photo -->
                        <div class="flex-shrink-0">
                            @if($testimonial->customer_photo)
                                <img src="{{ asset('storage/' . $testimonial->customer_photo) }}" 
                                     alt="{{ $testimonial->customer_name }}" 
                                     class="w-24 h-24 rounded-full object-cover border-4 border-blue-500 shadow-lg">
                            @else
                                <div class="w-24 h-24 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center border-4 border-blue-500 shadow-lg">
                                    <svg class="w-12 h-12 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 text-center md:text-left">
                            <!-- Quote Icon -->
                            <svg class="w-12 h-12 text-blue-500 opacity-50 mb-4 mx-auto md:mx-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                            </svg>
                            
                            <!-- Review Text -->
                            <p class="text-lg md:text-xl text-gray-700 dark:text-gray-300 mb-6 leading-relaxed italic">
                                "{{ $testimonial->review_text }}"
                            </p>
                            
                            <!-- Customer Name -->
                            <div class="font-bold text-xl text-gray-900 dark:text-white mb-2">
                                {{ $testimonial->customer_name }}
                            </div>
                            
                            <!-- Rating Stars -->
                            <div class="flex items-center justify-center md:justify-start space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-6 h-6 {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}" 
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    <!-- Navigation Arrows -->
    @if($testimonials->count() > 1)
    <div class="flex items-center justify-center mt-8 space-x-4">
        <button @click="prevSlide()" 
                class="p-3 rounded-full bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 disabled:opacity-50 disabled:cursor-not-allowed"
                :disabled="currentSlide === 0">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        
        <!-- Dots Indicator -->
        <div class="flex space-x-2">
            @foreach($testimonials as $index => $testimonial)
            <button @click="currentSlide = {{ $index }}" 
                    class="w-3 h-3 rounded-full transition-all duration-300"
                    :class="currentSlide === {{ $index }} ? 'bg-blue-600 w-8' : 'bg-gray-300 dark:bg-gray-600'">
            </button>
            @endforeach
        </div>
        
        <button @click="nextSlide()" 
                class="p-3 rounded-full bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 disabled:opacity-50 disabled:cursor-not-allowed"
                :disabled="currentSlide === {{ $testimonials->count() - 1 }}">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>
    @endif
</div>

<script>
    function testimonialSlider() {
        return {
            currentSlide: 0,
            totalSlides: {{ $testimonials->count() }},
            autoplayInterval: null,
            
            init() {
                this.startAutoplay();
            },
            
            nextSlide() {
                this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                this.resetAutoplay();
            },
            
            prevSlide() {
                this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
                this.resetAutoplay();
            },
            
            startAutoplay() {
                this.autoplayInterval = setInterval(() => {
                    this.nextSlide();
                }, 5000);
            },
            
            resetAutoplay() {
                clearInterval(this.autoplayInterval);
                this.startAutoplay();
            }
        }
    }
</script>

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
