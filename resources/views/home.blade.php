@extends('layouts.app')

@section('content')
    <!-- 1. Hero Section (Modern & Premium) -->
    <div class="relative w-full h-[450px] md:h-[600px] overflow-hidden group">
        <!-- Hero Image -->
        <img src="{{ asset('img/hero/hero.webp') }}" alt="Delicious Moments" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/30"></div>

        <!-- Content (Glassmorphism Card style) -->
        <div class="absolute inset-0 flex items-center justify-center md:justify-start px-4 md:px-20">
            <div class="max-w-2xl bg-white/10 backdrop-blur-md border border-white/20 p-8 md:p-12 rounded-3xl text-center md:text-left shadow-2xl">
                <span class="inline-block py-1 px-3 rounded-full bg-brand/20 text-sand text-xs font-bold tracking-widest uppercase mb-4 border border-sand/30">
                    Est. 2024
                </span>
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 font-display drop-shadow-lg leading-tight">
                    More Than Just <br/> <span class="text-sand">A Cup of Coffee</span>
                </h1>
                <p class="text-lg text-white/90 mb-8 font-light leading-relaxed">
                    Experience the finest blends and handcrafted treats, delivered straight to your doorstep.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="{{ route('menu') }}" class="px-8 py-3.5 bg-brand text-white font-bold rounded-2xl hover:bg-white hover:text-brand transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Order Now
                    </a>
                    <a href="#story" class="px-8 py-3.5 bg-transparent border border-white/40 text-white font-bold rounded-2xl hover:bg-white/10 transition-all backdrop-blur-sm">
                        Our Story
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Shop by Category (New Section) -->
    <div class="bg-white py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <span class="text-brand font-bold uppercase tracking-wider text-sm">Explore Menu</span>
                    <h2 class="text-3xl font-bold text-cocoa mt-2">Shop by Category</h2>
                </div>
                <a href="{{ route('menu') }}" class="hidden md:inline-flex items-center text-brand font-semibold hover:underline">
                    View All Menu <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('menu') }}" class="group flex flex-col items-center">
                        <div class="w-24 h-24 md:w-32 md:h-32 rounded-full bg-blush overflow-hidden shadow-sm group-hover:shadow-md transition-all group-hover:scale-105 border-2 border-transparent group-hover:border-brand/20 flex items-center justify-center">
                             <!-- Using a generic placeholder icon/image logic based on category name -->
                             <img src="https://ui-avatars.com/api/?name={{ urlencode($category->name) }}&background=3d6b5a&color=fff" 
                                class="w-full h-full object-cover p-2 rounded-full opacity-90 group-hover:opacity-100 transition-opacity">
                        </div>
                        <h3 class="mt-4 font-bold text-cocoa group-hover:text-brand transition-colors text-center">{{ $category->name }}</h3>
                    </a>
                @endforeach
            </div>
             <div class="mt-8 text-center md:hidden">
                <a href="{{ route('menu') }}" class="inline-flex items-center text-brand font-semibold hover:underline">
                    View All Menu <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- 3. Promotions Section (Refined) -->
    <div class="bg-blush py-20 px-4 relative overflow-hidden">
        <!-- Decorative bg elements -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-sand/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-brand/5 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            <h2 class="text-3xl md:text-5xl font-bold text-center text-cocoa mb-16 font-display">
                Seasonal Favorites & <span class="text-brand">Exclusive Deals</span>
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
                    class="relative w-full max-w-6xl mx-auto h-[500px] md:h-[450px] rounded-[2rem] overflow-hidden shadow-2xl group bg-white border border-white/50"
                    @mouseenter="stopRotation"
                    @mouseleave="startRotation">

                    <!-- Slides -->
                    @foreach($promotions as $index => $promotion)
                        <div x-show="activeSlide === {{ $index }}"
                             x-transition:enter="transition ease-out duration-700"
                             x-transition:enter-start="opacity-0 translate-x-10 scale-95"
                             x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                             x-transition:leave="transition ease-in duration-500"
                             x-transition:leave-start="opacity-100 translate-x-0 scale-100"
                             x-transition:leave-end="opacity-0 -translate-x-10 scale-95"
                             class="absolute inset-0 w-full h-full flex flex-col md:flex-row">
                            
                            <!-- Image Side (Left) -->
                            <div class="w-full md:w-1/2 h-64 md:h-full relative overflow-hidden group-hover:scale-[1.02] transition-transform duration-700">
                                @if($promotion->image_path)
                                    <img src="{{ asset($promotion->image_path) }}" 
                                         class="w-full h-full object-cover"
                                         onerror="this.src='https://via.placeholder.com/800x600?text={{ urlencode($promotion->name) }}'">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                                        No Image
                                    </div>
                                @endif
                            </div>

                            <!-- Content Side (Right) -->
                            <div class="w-full md:w-1/2 h-auto md:h-full bg-white flex flex-col justify-center p-8 md:p-12 relative">
                                <span class="uppercase tracking-widest text-xs font-bold text-brand mb-3">Limited Edition</span>
                                <h3 class="text-3xl md:text-5xl font-bold text-cocoa mb-4 font-display leading-tight">{{ $promotion->name }}</h3>
                                <p class="text-gray-500 mb-8 text-base md:text-lg leading-relaxed">{{ $promotion->description }}</p>
                                
                                <div class="mt-auto flex items-center gap-6">
                                    <div class="text-3xl md:text-4xl font-bold text-brand">Rs. {{ number_format($promotion->price, 0) }}</div>
                                    <a href="{{ route('menu') }}" class="px-6 py-3 bg-cocoa text-white rounded-xl font-bold hover:bg-brand transition-colors shadow-lg">
                                        Add to Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Minimal Controls -->
                    <div class="absolute bottom-6 right-6 flex gap-2 z-20">
                        <button @click="prevSlide" class="w-10 h-10 rounded-full bg-brand/10 hover:bg-brand text-brand hover:text-white flex items-center justify-center transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                         <button @click="nextSlide" class="w-10 h-10 rounded-full bg-brand/10 hover:bg-brand text-brand hover:text-white flex items-center justify-center transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>
            @else
                 <div class="text-center py-12 text-gray-500">
                    <p class="text-xl">Stay tuned for upcoming promotions!</p>
                </div>
            @endif
        </div>
    </div>

    <!-- 4. Our Story / Experience Section -->
    <div id="story" class="py-24 px-4 bg-white relative">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row items-center gap-16">
                 <div class="w-full md:w-1/2 relative order-2 md:order-1">
                    <div class="relative rounded-[2.5rem] overflow-hidden shadow-2xl">
                         <!-- Use a nice placeholder or existing image if available -->
                        <img src="https://images.unsplash.com/photo-1497935586351-b67a49e012bf?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Coffee Aesthetic" class="w-full object-cover h-[500px]">
                        <div class="absolute inset-0 bg-brand/10 mix-blend-multiply"></div>
                    </div>
                     <!-- Floating Badge -->
                    <div class="absolute -bottom-8 -right-8 bg-white p-6 rounded-2xl shadow-xl max-w-xs hidden md:block border border-gray-100">
                        <p class="text-brand font-bold text-lg mb-1">“Best Coffee in Town”</p>
                        <div class="flex text-yellow-400">★★★★★</div>
                        <p class="text-xs text-gray-400 mt-2">- Local Critic</p>
                    </div>
                </div>

                <div class="w-full md:w-1/2 order-1 md:order-2">
                    <span class="text-brand font-bold uppercase tracking-widest text-sm">The IceMacha Experience</span>
                    <h2 class="text-4xl md:text-5xl font-bold text-cocoa mt-4 mb-6 font-display leading-tight">
                        Crafted for the <br/><span class="text-brand/80">Bold & Curious.</span>
                    </h2>
                    <p class="text-gray-600 text-lg leading-relaxed mb-6">
                        Inspired by the vibrant cafe culture of Sri Lanka, we bring you a fusion of traditional flavors and modern brewing techniques. Whether you're here for a quick espresso or a relaxed evening with friends, every cup tells a story.
                    </p>
                    <p class="text-gray-600 text-lg leading-relaxed mb-8">
                        Our beans are ethically sourced, our pastries baked fresh daily, and our space designed to spark creativity.
                    </p>
                    <a href="{{ route('about') }}" class="text-brand font-bold border-b-2 border-brand hover:text-cocoa hover:border-cocoa transition-colors pb-1 inline-flex items-center">
                        Read Our Full Story <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
