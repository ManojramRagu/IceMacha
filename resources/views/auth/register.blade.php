@extends('layouts.app')

@section('content')
    <x-auth-card>
        <!-- Title -->
        <h2 class="text-2xl md:text-3xl font-bold text-center text-brand mb-6">
            Create your account
        </h2>

        <!-- Validation Errors -->
        <x-validation-errors class="mb-4" />

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Full Name Field -->
            <div>
                <label for="name" class="block text-sm font-semibold text-cocoa/80 mb-1">
                    Full name
                </label>
                <input id="name" 
                       type="text" 
                       name="name" 
                       value="{{ old('name') }}" 
                       required 
                       autofocus 
                       autocomplete="name"
                       placeholder="Jane Doe"
                       class="w-full px-4 py-3 rounded-xl border border-cocoa/20 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand/50 transition-colors duration-150">
            </div>

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
                       autocomplete="username"
                       placeholder="you@example.com"
                       class="w-full px-4 py-3 rounded-xl border border-cocoa/20 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand/50 transition-colors duration-150">
            </div>

            <!-- Password Fields (Side by Side) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-cocoa/80 mb-1">
                        Password
                    </label>
                    <input id="password" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="new-password"
                           placeholder="At least 4 characters"
                           class="w-full px-4 py-3 rounded-xl border border-cocoa/20 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand/50 transition-colors duration-150">
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-cocoa/80 mb-1">
                        Confirm password
                    </label>
                    <input id="password_confirmation" 
                           type="password" 
                           name="password_confirmation" 
                           required 
                           autocomplete="new-password"
                           placeholder="Repeat password"
                           class="w-full px-4 py-3 rounded-xl border border-cocoa/20 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand/50 transition-colors duration-150">
                </div>
            </div>

            <!-- Contact Number (Optional) -->
            <div>
                <label for="contact_number" class="block text-sm font-semibold text-cocoa/80 mb-1">
                    Contact number <span class="text-gray-400 font-normal">(optional)</span>
                </label>
                <input id="contact_number" 
                       type="tel" 
                       name="contact_number" 
                       value="{{ old('contact_number') }}" 
                       autocomplete="tel"
                       placeholder="+94 7X XXX XXXX"
                       class="w-full px-4 py-3 rounded-xl border border-cocoa/20 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand/50 transition-colors duration-150">
            </div>

            <!-- Address (Optional) -->
            <div>
                <label for="address" class="block text-sm font-semibold text-cocoa/80 mb-1">
                    Address <span class="text-gray-400 font-normal">(optional)</span>
                </label>
                <textarea id="address" 
                          name="address" 
                          rows="3"
                          autocomplete="street-address"
                          placeholder="Street, City, Postal Code"
                          class="w-full px-4 py-3 rounded-xl border border-cocoa/20 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand/50 transition-colors duration-150 resize-none">{{ old('address') }}</textarea>
            </div>

            <!-- Terms and Conditions -->
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="flex items-start">
                    <input id="terms" 
                           type="checkbox" 
                           name="terms" 
                           required
                           class="w-4 h-4 mt-1 text-brand bg-white border-cocoa/20 rounded focus:ring-brand/30 focus:ring-2">
                    <label for="terms" class="ml-2 text-sm text-cocoa/70">
                        I agree to the 
                        <a href="{{ route('terms.show') }}" target="_blank" class="text-brand hover:underline font-semibold">Terms of Service</a> 
                        and 
                        <a href="{{ route('policy.show') }}" target="_blank" class="text-brand hover:underline font-semibold">Privacy Policy</a>
                    </label>
                </div>
            @endif

            <!-- Submit Button & Link -->
            <div class="space-y-4">
                <button type="submit" 
                        class="w-full px-6 py-3 bg-brand text-white font-semibold rounded-2xl hover:opacity-90 transition-opacity duration-150">
                    Create account
                </button>

                <div class="text-center text-sm">
                    <a href="{{ route('login') }}" 
                       class="text-cocoa hover:text-brand transition-colors duration-150">
                        Already have an account? <span class="font-semibold underline">Sign in</span>
                    </a>
                </div>
            </div>
        </form>
    </x-auth-card>
@endsection
