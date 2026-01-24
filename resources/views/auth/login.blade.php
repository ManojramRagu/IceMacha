@extends('layouts.app')

@section('content')
    <x-auth-card>
        <!-- Title -->
        <h2 class="text-2xl md:text-3xl font-bold text-center text-brand mb-6">
            Sign in
        </h2>

        <!-- Validation Errors -->
        <x-validation-errors class="mb-4" />

        <!-- Status Message -->
        @session('status')
            <div class="mb-4 font-medium text-sm text-green-700 bg-green-50 border border-green-200 rounded-xl p-3">
                {{ $value }}
            </div>
        @endsession

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-semibold text-cocoa/80 mb-1">
                    Email
                </label>
                <input id="email" 
                       type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus 
                       autocomplete="username"
                       placeholder="you@example.com"
                       class="w-full px-4 py-3 rounded-xl border border-cocoa/20 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand/50 transition-colors duration-150">
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-semibold text-cocoa/80 mb-1">
                    Password
                </label>
                <input id="password" 
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="current-password"
                       placeholder="********"
                       class="w-full px-4 py-3 rounded-xl border border-cocoa/20 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand/50 transition-colors duration-150">
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me" 
                       type="checkbox" 
                       name="remember"
                       class="w-4 h-4 text-brand bg-white border-cocoa/20 rounded focus:ring-brand/30 focus:ring-2">
                <label for="remember_me" class="ml-2 text-sm text-cocoa/70">
                    Remember me
                </label>
            </div>

            <!-- Submit Button & Links -->
            <div class="space-y-4">
                <button type="submit" 
                        class="w-full px-6 py-3 bg-brand text-white font-semibold rounded-2xl hover:opacity-90 transition-opacity duration-150">
                    Sign in
                </button>

                <div class="flex flex-col sm:flex-row justify-between items-center gap-2 text-sm">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" 
                           class="text-cocoa hover:text-brand transition-colors duration-150 underline">
                            Forgot your password?
                        </a>
                    @endif
                    
                    <a href="{{ route('register') }}" 
                       class="text-cocoa hover:text-brand transition-colors duration-150">
                        New here? <span class="font-semibold underline">Create an account</span>
                    </a>
                </div>
            </div>
        </form>
    </x-auth-card>
@endsection
