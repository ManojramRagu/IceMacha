@extends('layouts.app')

@section('content')
    <!-- 1. Hero / Header -->
    <div class="relative w-full h-[400px] overflow-hidden">
        <img src="{{ asset('img/hero/hero.webp') }}" class="absolute inset-0 w-full h-full object-cover">
         <div class="absolute inset-0 bg-black/60 flex flex-col items-center justify-center text-center px-4">
             <span class="text-brand font-bold uppercase tracking-widest text-sm mb-2">Since 2024</span>
             <h1 class="text-4xl md:text-6xl text-white font-bold font-display mb-6">Crafting Joyful Moments</h1>
             <p class="text-xl text-white/90 max-w-2xl font-light">
                 More than just a cafe. We are a community dedicated to the art of flavor and the joy of connection.
             </p>
         </div>
    </div>

    <!-- 2. The Philosophy (Values) -->
    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                 <h2 class="text-3xl font-bold text-cocoa">Our Philosophy</h2>
                 <p class="text-gray-500 mt-4 max-w-2xl mx-auto">
                     We believe in three simple things:
                 </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Value 1: Quality -->
                <div class="text-center group p-8 rounded-3xl hover:bg-blush/30 transition-colors duration-300">
                    <div class="w-20 h-20 mx-auto bg-brand/10 text-brand rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-cocoa mb-4">Uncompromising Quality</h3>
                    <p class="text-gray-600 leading-relaxed">
                        From ethically sourced beans to the freshest local produce, we never take shortcuts. Every ingredient tells a story of care.
                    </p>
                </div>

                <!-- Value 2: Community -->
                <div class="text-center group p-8 rounded-3xl hover:bg-blush/30 transition-colors duration-300">
                    <div class="w-20 h-20 mx-auto bg-brand/10 text-brand rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-cocoa mb-4">Community First</h3>
                    <p class="text-gray-600 leading-relaxed">
                        We aren't just a business; we're a neighbor. We create spaces for connection, creativity, and conversation.
                    </p>
                </div>

                <!-- Value 3: Innovation -->
                <div class="text-center group p-8 rounded-3xl hover:bg-blush/30 transition-colors duration-300">
                    <div class="w-20 h-20 mx-auto bg-brand/10 text-brand rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                         <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-cocoa mb-4">Tasty Innovation</h3>
                    <p class="text-gray-600 leading-relaxed">
                        We love analyzing and reinventing classics. Our menu is a playful experiment in flavor optimization.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Join the Vibe (CTA) -->
    <div class="relative py-24 bg-cocoa overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div> <!-- Optional external pattern or just remove -->
        <!-- Actually, better to just use a gradient or remove. I'll remove the url and just keep opacity or remove the line if I can't guarantee an asset. -->
        <!-- Let's just remove the pattern div or make it a gradient. -->
        <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent pointer-events-none"></div>
        
        <div class="max-w-4xl mx-auto px-4 relative z-10 text-center">
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-8 font-display">Ready for a Taste?</h2>
            <p class="text-xl text-white/80 mb-10 font-light">
                Come visit us or order online to experience the magic yourself.
            </p>
            <div class="flex justify-center gap-6">
                 <a href="{{ route('menu') }}" class="px-8 py-4 bg-brand text-white font-bold rounded-2xl hover:bg-white hover:text-brand transition-all shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                    Order Online
                </a>
                <a href="{{ route('contact') }}" class="px-8 py-4 bg-transparent border border-white/30 text-white font-bold rounded-2xl hover:bg-white/10 transition-all backdrop-blur-sm">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
@endsection
