<nav x-data="{ open: false }" class="bg-brand border-b border-brand shadow-sm relative z-50" style="height: 100px;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full relative">
        <div class="flex justify-center items-center h-full relative">
            
            <!-- Center Navigation Cluster -->
            <div class="hidden sm:flex items-center gap-12 relative z-20">
                <a href="{{ route('home') }}" class="text-white hover:text-sand font-medium transition-colors {{ request()->routeIs('home') ? 'font-bold' : '' }}">
                    Home
                </a>
                <a href="{{ route('menu') }}" class="text-white hover:text-sand font-medium transition-colors {{ request()->routeIs('menu') ? 'font-bold' : '' }}">
                    Menu
                </a>

                <!-- Spacer for Logo -->
                <div class="w-48 shrink-0"></div>

                <a href="#about" class="text-white hover:text-sand font-medium transition-colors">
                    About
                </a>
                <a href="#" class="text-white hover:text-sand font-medium transition-colors">
                    Contact
                </a>
            </div>

            <!-- Logo (Absolute Top Center) -->
            <div class="absolute left-1/2 top-0 transform -translate-x-1/2 z-30">
                <a href="{{ route('home') }}" class="bg-white p-3 rounded-b-2xl shadow-lg block transition hover:scale-105 duration-300">
                    <img src="{{ asset('img/logo.webp') }}" class="block h-14 w-auto" alt="IceMacha" />
                </a>
            </div>

            <!-- Right Side Utility (Absolute Right) -->
            <div class="hidden sm:flex items-center gap-6 absolute right-0 top-1/2 -translate-y-1/2 z-20">
                <!-- Cart Icon -->
                <div class="flex items-center text-white">
                    <livewire:cart-icon />
                </div>

                <!-- Authentication -->
                @auth
                    <!-- Settings Dropdown -->
                    <div class="relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-white hover:text-sand focus:outline-none transition">
                                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                        <img class="size-8 rounded-full object-cover border-2 border-white" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    @else
                                        <div class="size-8 rounded-full bg-white text-brand flex items-center justify-center font-bold">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </div>

                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <div class="border-t border-gray-100"></div>

                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}"
                                             @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-white hover:text-sand transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </a>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <div class="me-4 text-white">
                    <livewire:cart-icon />
                </div>
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-sand hover:bg-brand/80 focus:outline-none focus:bg-brand/80 transition duration-150 ease-in-out">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-brand border-t border-brand/80">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')" class="text-white hover:bg-brand/80">
                Home
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('menu') }}" :active="request()->routeIs('menu')" class="text-white hover:bg-brand/80">
                Menu
            </x-responsive-nav-link>
            @auth
                <x-responsive-nav-link href="{{ route('my-orders') }}" :active="request()->routeIs('my-orders')" class="text-white hover:bg-brand/80">
                    {{ __('My Orders') }}
                </x-responsive-nav-link>
            @endauth
            <x-responsive-nav-link href="#about" class="text-white hover:bg-brand/80">
                About
            </x-responsive-nav-link>
        </div>

        @auth
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-brand/80">
                <div class="flex items-center px-4">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div class="shrink-0 me-3">
                            <img class="size-10 rounded-full object-cover border-2 border-white" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        </div>
                    @endif

                    <div>
                        <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-sand">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')" class="text-white hover:bg-brand/80">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <x-responsive-nav-link href="{{ route('logout') }}"
                                       @click.prevent="$root.submit();" class="text-white hover:bg-brand/80">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-4 border-t border-brand/80">
                <div class="space-y-1 px-4">
                    <a href="{{ route('login') }}" class="block w-full text-center py-2 text-white font-semibold border border-white rounded-lg mb-2 hover:bg-white/10">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" class="block w-full text-center py-2 text-brand font-semibold bg-white rounded-lg hover:bg-gray-100">
                        Register
                    </a>
                </div>
            </div>
        @endauth
    </div>
</nav>