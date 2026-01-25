@extends('layouts.app')

@section('content')
    <!-- Full-Width Auto-Rotating Carousel Hero -->
    <div x-data="{
            activeSlide: 0,
            slides: [
                { image: '{{ asset('img/products/Promotions/Summer Coolers.webp') }}', title: 'Summer Coolers', desc: 'Beat the heat with our refreshing blends.' },
                { image: '{{ asset('img/products/Promotions/Coffee Lovers.webp') }}', title: 'Coffee Lovers Special', desc: 'Double the caffeine, double the fun.' },
                { image: '{{ asset('img/products/Promotions/Festive Treats.webp') }}', title: 'Festive Treats', desc: 'Celebrate the season with exclusive flavors.' },
                { image: '{{ asset('img/products/Promotions/Healthy Mornings.webp') }}', title: 'Healthy Mornings', desc: 'Start your day right with nutritious combos.' },
                { image: '{{ asset('img/products/Promotions/Midnight Snacks.webp') }}', title: 'Midnight Snack Deals', desc: 'Late night cravings? We got you covered.' }
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
        class="relative w-full h-[600px] overflow-hidden group bg-blush"
        @mouseenter="stopRotation"
        @mouseleave="startRotation">

        <!-- Slides -->
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-700"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0 w-full h-full">
                
                <img :src="slide.image" class="w-full h-full object-cover">
                
                <!-- Black/40 Overlay -->
                <div class="absolute inset-0 bg-black/40"></div>

                <!-- Hero Content Overlay -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="text-center text-white px-4 pointer-events-auto">
                        <h1 class="text-5xl md:text-7xl font-bold mb-6 font-display drop-shadow-xl tracking-wide" x-text="slide.title"></h1>
                        <p class="text-xl md:text-2xl mb-10 font-light drop-shadow-md opacity-90" x-text="slide.desc"></p>
                        <a href="{{ route('menu') }}" 
                           class="inline-block px-10 py-4 bg-brand text-white font-bold rounded-full hover:bg-opacity-90 transition-all shadow-xl hover:scale-105 hover:shadow-2xl text-lg">
                            Buy Now
                        </a>
                    </div>
                </div>
            </div>
        </template>

        <!-- Navigation Buttons (Appear on Hover) -->
        <button @click="prevSlide" 
                class="absolute left-6 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-4 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 backdrop-blur-sm hover:scale-110">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button @click="nextSlide" 
                class="absolute right-6 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-4 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 backdrop-blur-sm hover:scale-110">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>

        <!-- Dots -->
        <div class="absolute bottom-8 left-0 right-0 flex justify-center space-x-4">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" 
                        class="w-4 h-4 rounded-full transition-all duration-300 border-2 border-white/50"
                        :class="activeSlide === index ? 'bg-brand scale-125 border-brand' : 'bg-transparent hover:bg-white/30'">
                </button>
            </template>
        </div>
    </div>
@endsection
