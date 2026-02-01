@extends('layouts.app')

@section('content')
    <x-auth-card>
        <!-- Title -->
        <h2 class="text-2xl md:text-3xl font-bold text-center text-brand mb-6">
            {{ __('Confirm Password') }}
        </h2>

        <div class="mb-6 text-sm text-cocoa/70 text-center">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
            @csrf

            <div>
                <label for="password" class="block text-sm font-semibold text-cocoa/80 mb-1">
                    {{ __('Password') }}
                </label>
                <input id="password" 
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="current-password" 
                       autofocus 
                       placeholder="********"
                       class="w-full px-4 py-3 rounded-xl border border-cocoa/20 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand/50 transition-colors duration-150">
            </div>

            <div class="pt-2">
                <button type="submit" 
                        class="w-full px-6 py-3 bg-brand text-white font-semibold rounded-2xl hover:opacity-90 transition-opacity duration-150">
                    {{ __('Confirm') }}
                </button>
            </div>
        </form>
    </x-auth-card>
@endsection
