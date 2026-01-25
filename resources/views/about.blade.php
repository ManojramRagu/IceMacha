@extends('layouts.app')

@section('content')
    <div class="bg-blush min-h-screen">
        <!-- Page Title -->


        <div class="max-w-6xl mx-auto px-4 py-12 space-y-24">
            
            <!-- Our Story -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <!-- Image Left -->
                <div class="order-1">
                    <img src="{{ asset('img/about/story.webp') }}" 
                         alt="Our Story" 
                         class="w-full h-64 object-cover rounded-3xl shadow-lg transform hover:scale-105 transition-transform duration-500">
                </div>
                <!-- Text Right -->
                <div class="order-2 text-cocoa">
                    <h2 class="text-3xl font-bold text-brand mb-6 font-display">Our Story</h2>
                    <div class="space-y-4 text-lg leading-relaxed">
                        <p>
                            IceMacha was born from a passion for bringing high-quality beverages and snacks to busy lives. 
                            From humble beginnings, we have grown into a platform that delivers freshness, flavor, 
                            and convenience directly to our customers' doors, making every sip and bite a memorable experience.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Our Commitment -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <!-- Text Left -->
                <div class="order-2 md:order-1 text-cocoa">
                    <h2 class="text-3xl font-bold text-brand mb-6 font-display">Our Commitment</h2>
                    <div class="space-y-4 text-lg leading-relaxed">
                        <p>
                            We are dedicated to using only the finest ingredients and crafting each product with care. 
                            Quality, consistency, and customer satisfaction are at the heart of everything we do, 
                            ensuring that every order you receive meets the highest standards.
                        </p>
                    </div>
                </div>
                <!-- Image Right -->
                <div class="order-1 md:order-2">
                    <img src="{{ asset('img/about/commitment.webp') }}" 
                         alt="Our Commitment" 
                         class="w-full h-64 object-cover rounded-3xl shadow-lg transform hover:scale-105 transition-transform duration-500">
                </div>
            </div>

            <!-- Our Vision -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <!-- Image Left -->
                <div class="order-1">
                    <img src="{{ asset('img/about/vision.webp') }}" 
                         alt="Our Vision" 
                         class="w-full h-64 object-cover rounded-3xl shadow-lg transform hover:scale-105 transition-transform duration-500">
                </div>
                <!-- Text Right -->
                <div class="order-2 text-cocoa">
                    <h2 class="text-3xl font-bold text-brand mb-6 font-display">Our Vision</h2>
                    <div class="space-y-4 text-lg leading-relaxed">
                        <p>
                            Our goal is to redefine how people enjoy food and beverages online. By combining technology, 
                            creativity, and exceptional service, IceMacha aims to make delicious, wholesome treats 
                            accessible to everyone, anytime and anywhere.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
