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

    <!-- About Section - Our Story -->
    <section class="max-w-6xl mx-auto px-4 py-12 md:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <!-- Image -->
            <div class="order-2 md:order-1">
                <img src="{{ asset('img/about/story.webp') }}" 
                     alt="Our Story" 
                     class="w-full h-auto rounded-2xl shadow-md"
                     loading="lazy">
            </div>
            
            <!-- Text Content -->
            <div class="order-1 md:order-2">
                <h2 class="text-3xl md:text-4xl font-bold text-brand mb-4 font-display">
                    Our Story
                </h2>
                <div class="text-cocoa space-y-4 font-display">
                    <p class="leading-relaxed">
                        Welcome to <span class="font-semibold">IceMacha</span>, where every sip tells a story. 
                        We're passionate about crafting the finest beverages and delivering exceptional 
                        food experiences right to your doorstep.
                    </p>
                    <p class="leading-relaxed">
                        From aromatic coffees to refreshing iced drinks, delicious snacks to gourmet treats, 
                        we believe in quality, freshness, and the joy of sharing great moments with great food.
                    </p>
                    <p class="leading-relaxed">
                        Our journey began with a simple mission: to bring cafe-quality drinks and food 
                        to everyone, anywhere. Today, we're proud to serve our community with love, 
                        dedication, and a commitment to excellence.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <x-footer />
@endsection
