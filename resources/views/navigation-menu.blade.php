<nav x-data="{ open: false }" class="bg-brand border-b border-brand shadow-sm relative z-50" style="height: 100px;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full relative">

        {{-- DESKTOP NAVIGATION --}}
        <div class="hidden sm:flex justify-center items-center h-full relative">
            <!-- Center Navigation Cluster -->
            <div class="flex items-center gap-12 relative z-20">
                <a href="{{ route('home') }}" class="text-white hover:text-sand font-medium transition-colors {{ request()->routeIs('home') ? 'font-bold' : '' }}">Home</a>
                <a href="{{ route('menu') }}" class="text-white hover:text-sand font-medium transition-colors {{ request()->routeIs('menu') ? 'font-bold' : '' }}">Menu</a>
                <div class="w-48 shrink-0"></div> <!-- Logo Spacer -->
                <a href="{{ route('about') }}" class="text-white hover:text-sand font-medium transition-colors {{ request()->routeIs('about') ? 'font-bold' : '' }}">About</a>
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('admin') }}" class="text-white hover:text-sand font-medium transition-colors">Admin</a>
                @else
                    <a href="{{ route('contact') }}" class="text-white hover:text-sand font-medium transition-colors {{ request()->routeIs('contact') ? 'font-bold' : '' }}">Contact</a>
                @endif
            </div>

            <!-- Logo (Absolute Center) -->
            <div class="absolute left-1/2 top-0 transform -translate-x-1/2 z-30">
                <a href="{{ route('home') }}" class="bg-white p-3 rounded-b-2xl shadow-lg block transition hover:scale-105 duration-300">
                    <img src="{{ asset('img/logo.webp') }}" class="block h-14 w-auto" alt="IceMacha" />
                </a>
            </div>

            <!-- Right Side Utility -->
            <div class="flex items-center gap-6 absolute right-0 top-1/2 -translate-y-1/2 z-20">
                <div class="flex items-center text-white"><livewire:cart-icon /></div>
                @auth
                    <a href="{{ route('my-orders') }}" class="text-white hover:text-sand transition-colors group relative" title="Orders">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </a>
                    <div class="relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-white hover:text-sand focus:outline-none transition">
                                    <img class="size-8 rounded-full object-cover border-2 border-white" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link href="{{ route('profile.show') }}">{{ __('Profile') }}</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">{{ __('Log Out') }}</x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-white hover:text-sand transition-colors"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg></a>
                @endauth
            </div>
        </div>

        {{-- MOBILE NAVIGATION --}}
        <div class="flex sm:hidden justify-between items-center h-full px-2">
            <!-- Left: Hamburger -->
            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-sand focus:outline-none transition duration-150 ease-in-out z-50">
                <svg class="size-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Center: Logo -->
            <a href="{{ route('home') }}" class="flex-shrink-0">
                <img src="{{ asset('img/logo.webp') }}" class="block h-12 w-auto drop-shadow-md" alt="IceMacha" />
            </a>

            <!-- Right: Profile / Login -->
            <div class="flex items-center">
                 @auth
                    <div class="relative ml-3" x-data="{ userMenuOpen: false }">
                        <button @click="userMenuOpen = !userMenuOpen" class="flex items-center p-1 focus:outline-none">
                             <img class="size-8 rounded-full object-cover border border-white shadow-sm" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        </button>
                        
                        <!-- Mobile Profile Dropdown -->
                        <div x-show="userMenuOpen" 
                             @click.away="userMenuOpen = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50 origin-top-right"
                             style="display: none;">
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ __('Profile') }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <a href="{{ route('logout') }}" @click.prevent="$root.submit();" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-white p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Mobile Side-out Menu -->
    <div x-show="open" 
         class="fixed inset-0 z-50 sm:hidden"
         style="display: none;">
         
        <!-- Backdrop Blur -->
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" 
             x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="open = false">
        </div>

        <!-- Off-canvas Sidebar (Left Side) -->
        <div class="fixed inset-y-0 left-0 max-w-xs w-full bg-brand shadow-2xl transform transition-transform"
             x-show="open"
             x-transition:enter="transform transition ease-in-out duration-300"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transform transition ease-in-out duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full">
             
             <div class="h-full flex flex-col py-6 overflow-y-auto">
                <!-- Header -->
                <div class="px-6 flex items-center justify-between mb-8">
                    <img src="{{ asset('img/logo.webp') }}" class="h-10 w-auto" alt="IceMacha" />
                    <button @click="open = false" class="text-white hover:text-sand transition-colors">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links -->
                <div class="flex-1 px-4 space-y-2">
                    <a href="{{ route('home') }}" class="block px-4 py-3 rounded-xl text-lg font-bold transition-all {{ request()->routeIs('home') ? 'bg-white text-brand shadow-md' : 'text-white hover:bg-white/10' }}">
                        Home
                    </a>
                    <a href="{{ route('menu') }}" class="block px-4 py-3 rounded-xl text-lg font-bold transition-all {{ request()->routeIs('menu') ? 'bg-white text-brand shadow-md' : 'text-white hover:bg-white/10' }}">
                        Menu
                    </a>
                    
                    {{-- User Links (Cart & Orders) - Styled as Cards --}}
                    <div class="grid grid-cols-2 gap-3 my-4">
                        <a href="{{ route('checkout') }}" class="flex flex-col items-center justify-center p-4 bg-white/10 hover:bg-white/20 rounded-2xl border border-white/10 transition-all text-white group">
                            <div class="bg-white text-brand p-2 rounded-full mb-2 group-hover:scale-110 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                            </div>
                            <span class="text-sm font-bold">Cart</span>
                        </a>
                        
                        @auth
                            <a href="{{ route('my-orders') }}" class="flex flex-col items-center justify-center p-4 bg-white/10 hover:bg-white/20 rounded-2xl border border-white/10 transition-all text-white group">
                                <div class="bg-white text-brand p-2 rounded-full mb-2 group-hover:scale-110 transition-transform">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-bold">Orders</span>
                            </a>
                        @else
                             <a href="{{ route('login') }}" class="flex flex-col items-center justify-center p-4 bg-white/10 hover:bg-white/20 rounded-2xl border border-white/10 transition-all text-white group">
                                <div class="bg-white text-brand p-2 rounded-full mb-2 group-hover:scale-110 transition-transform">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-bold">Login</span>
                            </a>
                        @endauth
                    </div>

                    <a href="{{ route('about') }}" class="block px-4 py-3 rounded-xl text-lg font-bold transition-all {{ request()->routeIs('about') ? 'bg-white text-brand shadow-md' : 'text-white hover:bg-white/10' }}">
                        About
                    </a>

                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <a href="{{ route('admin') }}" class="block px-4 py-3 rounded-xl text-lg font-bold transition-all text-white hover:bg-white/10">
                            Admin Dashboard
                        </a>
                    @else
                        <a href="{{ route('contact') }}" class="block px-4 py-3 rounded-xl text-lg font-bold transition-all {{ request()->routeIs('contact') ? 'bg-white text-brand shadow-md' : 'text-white hover:bg-white/10' }}">
                            Contact Us
                        </a>
                    @endif
                </div>

                <!-- Footer / Auth -->
                <div class="px-6 pt-8 mt-4 border-t border-white/10">
                    @auth
                        <div class="flex items-center gap-4 mb-6">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <img class="h-10 w-10 rounded-full object-cover border-2 border-white" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            @else
                                <div class="h-10 w-10 rounded-full bg-white text-brand flex items-center justify-center font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <div class="font-bold text-white">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-sand">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        
                        <a href="{{ route('profile.show') }}" class="block w-full text-center py-3 mb-3 text-white border border-white/30 rounded-xl hover:bg-white/10 font-bold text-sm">
                            Manage Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <button type="submit" @click.prevent="$root.submit();" class="block w-full text-center py-3 bg-white text-brand rounded-xl font-bold shadow-lg text-sm">
                                Log Out
                            </button>
                        </form>
                    @else
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('login') }}" class="block w-full text-center py-3 text-white border border-white/30 rounded-xl hover:bg-white/10 font-bold transition-colors">
                                Log In
                            </a>
                            <a href="{{ route('register') }}" class="block w-full text-center py-3 bg-white text-brand rounded-xl font-bold shadow-lg transition-transform active:scale-95">
                                Register
                            </a>
                        </div>
                    @endauth
                </div>
             </div>
        </div>
    </div>
</nav>