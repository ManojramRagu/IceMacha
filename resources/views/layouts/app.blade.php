<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('img/logo.webp') }}" type="image/webp">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @yield('content', $slot ?? '')
            </main>
            
            <x-footer />
        </div>

        @stack('modals')

        {{-- Global Toast Notification --}}
        <div x-data="{ 
                show: false, 
                message: '', 
                type: 'success',
                showToast(event) {
                    this.type = event.detail.type || 'success';
                    this.message = event.detail.message || '';
                    this.show = true;
                    setTimeout(() => this.show = false, 3500);
                }
             }" 
             @toast.window="showToast($event)"
             x-show="show" 
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed bottom-6 right-6 z-[9999]"
             style="display: none;">
            <div :class="{
                    'bg-brand text-white': type === 'success',
                    'bg-white text-orange-600 border-2 border-orange-200': type === 'warning',
                    'bg-white text-red-600 border-2 border-red-200': type === 'error'
                 }" 
                 class="rounded-2xl shadow-2xl px-6 py-4 flex items-center gap-4 min-w-[300px]">
                 
                 {{-- Icon --}}
                 <div :class="{
                         'bg-white/20': type === 'success',
                         'bg-orange-100': type === 'warning',
                         'bg-red-100': type === 'error'
                      }" 
                      class="w-8 h-8 rounded-full flex items-center justify-center shrink-0">
                      
                      {{-- Success Icon --}}
                      <svg x-show="type === 'success'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                      </svg>
                      
                      {{-- Warning Icon --}}
                      <svg x-show="type === 'warning'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                      </svg>
                      
                      {{-- Error Icon --}}
                      <svg x-show="type === 'error'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                 </div>
                 
                 {{-- Message --}}
                 <div>
                     <p class="font-bold text-sm" x-text="type === 'success' ? 'Success' : (type === 'warning' ? 'Warning' : 'Error')"></p>
                     <p :class="{
                            'text-white/80': type === 'success',
                            'text-orange-500': type === 'warning',
                            'text-red-500': type === 'error'
                         }" 
                        class="text-xs" x-text="message"></p>
                 </div>
            </div>
        </div>

        @livewireScripts
    </body>
</html>
