@extends('layouts.app')

@section('content')
    <!-- 1. Static Hero Section -->
    <div class="relative w-full h-[350px] md:h-[450px] overflow-hidden">
        <!-- Hero Image -->
        <img src="{{ asset('img/hero/hero.webp') }}" alt="Delicious Moments" class="absolute inset-0 w-full h-full object-cover">
        
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/40"></div>

        <!-- Content -->
        <div class="absolute inset-0 flex items-center justify-center text-center px-4">
            <div class="max-w-4xl">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 drop-shadow-xl tracking-wide">
                    Delicious Moments Delivered to You
                </h1>
                <p class="text-lg md:text-2xl text-white/90 mb-8 font-light drop-shadow-md">
                    Fresh coffee, beverages, snacks. Browse, Order & Enjoy.
                </p>
                <a href="{{ route('menu') }}" class="inline-block bg-brand hover:bg-opacity-90 text-white font-bold py-3 px-8 rounded-full shadow-lg transition-transform transform hover:scale-105">
                    Browse Menu
                </a>
            </div>
        </div>
    </div>

    <!-- 2. Promotions Section -->
    <div class="bg-blush py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-brand mb-12">
                Promotions & Seasonal Offers
            </h2>

            <!-- Dynamic Carousel -->
            @if($promotions->count() > 0)
                <div x-data="{
                        activeSlide: 0,
                        totalSlides: {{ $promotions->count() }},
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
                            this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
                        },
                        prevSlide() {
                            this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides;
                        }
                    }"
                    class="relative w-full max-w-5xl mx-auto h-[400px] rounded-3xl overflow-hidden shadow-2xl group bg-white"
                    @mouseenter="stopRotation"
                    @mouseleave="startRotation">

                    <!-- Slides -->
                    @foreach($promotions as $index => $promotion)
                        <div x-show="activeSlide === {{ $index }}"
                             x-transition:enter="transition ease-out duration-700"
                             x-transition:enter-start="opacity-0 translate-x-full"
                             x-transition:enter-end="opacity-100 translate-x-0"
                             x-transition:leave="transition ease-in duration-700"
                             x-transition:leave-start="opacity-100 translate-x-0"
                             x-transition:leave-end="opacity-0 -translate-x-full"
                             class="absolute inset-0 w-full h-full flex flex-col md:flex-row">
                            
                            <!-- Image Side (Left) -->
                            <div class="w-full md:w-1/2 h-64 md:h-full relative overflow-hidden">
                                @if($promotion->image_path)
                                    <img src="{{ asset($promotion->image_path) }}" 
                                         class="w-full h-full object-cover transition-transform duration-700 hover:scale-105"
                                         onerror="this.src='https://via.placeholder.com/800x600?text={{ urlencode($promotion->name) }}'">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                                        No Image
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-r from-black/20 to-transparent md:hidden"></div>
                            </div>

                            <!-- Content Side (Right) -->
                            <div class="w-full md:w-1/2 h-auto md:h-full bg-sand/20 flex flex-col justify-center p-8 md:p-12 text-center md:text-left relative">
                                <span class="uppercase tracking-widest text-xs font-bold text-brand mb-2">Limited Time Offer</span>
                                <h3 class="text-3xl md:text-5xl font-bold text-cocoa mb-4">{{ $promotion->name }}</h3>
                                <p class="text-gray-600 mb-6 text-sm md:text-base leading-relaxed">{{ $promotion->description }}</p>
                                
                                <div class="mt-auto">
                                    <div class="text-4xl font-bold text-brand mb-2">Just LKR {{ number_format($promotion->price, 0) }}</div>
                                    <a href="{{ route('menu') }}" class="inline-block text-cocoa font-bold hover:text-brand transition-colors border-b-2 border-brand pb-1">
                                        Order Now &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Controls -->
                    <button @click="prevSlide" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-brand p-3 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-all z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button @click="nextSlide" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-brand p-3 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-all z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                    
                    <!-- Dots -->
                    <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2 z-10">
                        @foreach($promotions as $index => $promotion)
                            <button @click="activeSlide = {{ $index }}" 
                                    class="w-3 h-3 rounded-full transition-all duration-300"
                                    :class="activeSlide === {{ $index }} ? 'bg-brand w-6' : 'bg-brand/30 hover:bg-brand/50'">
                            </button>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-12 text-gray-500 bg-white rounded-3xl shadow-sm max-w-4xl mx-auto">
                    <p class="text-xl">Stay tuned for upcoming promotions!</p>
                </div>
            @endif
        </div>
    </div>

@endsection
