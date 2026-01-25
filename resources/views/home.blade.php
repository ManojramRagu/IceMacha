@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="relative w-full overflow-hidden h-[220px] sm:h-[300px] md:h-[380px]">
        <!-- Hero Image -->
        <img src="{{ asset('img/hero/hero.webp') }}" 
             alt="IceMacha Hero" 
             class="absolute inset-0 w-full h-full object-cover"
             loading="eager">
        
        <!-- Black Overlay -->
        <div class="absolute inset-0 bg-black/30"></div>
        
        <!-- Hero Content -->
        <div class="relative z-10 h-full flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 tracking-wide">
                    IceMacha
                </h1>
                <p class="text-base sm:text-lg mb-6 font-medium">
                    Fresh coffee, beverages, snacks. Browse, Order & Enjoy.
                </p>
                <a href="{{ route('menu') }}" 
                   class="inline-block px-8 py-3 bg-brand text-white font-semibold rounded-2xl hover:opacity-90 transition-opacity duration-150">
                    View Menu
                </a>
            </div>
        </div>
    </div>

    <!-- Promotions Section -->
    <section class="max-w-7xl mx-auto px-4 py-8 md:py-12 bg-blush/30">
        <h2 class="text-2xl md:text-3xl font-bold text-center text-brand mb-8 font-display">
            Promotions & Seasonal Offers
        </h2>

        <!-- Carousel -->
        <div x-data="{
                activeSlide: 0,
                slides: [
                    '{{ asset('img/products/Promotions/Summer Coolers.webp') }}',
                    '{{ asset('img/products/Promotions/Coffee Lovers.webp') }}',
                    '{{ asset('img/products/Promotions/Festive Treats.webp') }}',
                    '{{ asset('img/products/Promotions/Healthy Mornings.webp') }}',
                    '{{ asset('img/products/Promotions/Midnight Snacks.webp') }}'
                ],
                timer: null,
                init() {
                    this.startRotation();
                },
                startRotation() {
                    this.timer = setInterval(() => {
                        this.nextSlide();
                    }, 5000);
                },
                stopRotation() {
                    clearInterval(this.timer);
                },
                nextSlide() {
                    this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                },
                prevSlide() {
                    this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length;
                }
            }"
            class="relative w-full max-w-5xl mx-auto overflow-hidden rounded-3xl shadow-xl group"
            @mouseenter="stopRotation"
            @mouseleave="startRotation">

            <!-- Slides -->
            <div class="relative h-[250px] sm:h-[350px] md:h-[450px]">
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="activeSlide === index"
                         x-transition:enter="transition ease-out duration-700"
                         x-transition:enter-start="opacity-0 transform scale-105"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-700"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         class="absolute inset-0 w-full h-full">
                        <img :src="slide" class="w-full h-full object-cover">
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-black/40"></div>
                    </div>
                </template>
            </div>

            <!-- Navigation Buttons -->
            <button @click="prevSlide" 
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button @click="nextSlide" 
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <!-- Dots -->
            <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2">
                <template x-for="(slide, index) in slides" :key="index">
                    <button @click="activeSlide = index" 
                            class="w-2.5 h-2.5 rounded-full transition-colors duration-300"
                            :class="activeSlide === index ? 'bg-brand' : 'bg-white/50 hover:bg-white'">
                    </button>
                </template>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center mt-12">
            <a href="{{ route('menu') }}"
               class="inline-block px-10 py-4 bg-brand text-white font-bold text-lg rounded-2xl shadow-lg hover:bg-brand/90 hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                Buy Now
            </a>
        </div>
    </section>

@endsection
