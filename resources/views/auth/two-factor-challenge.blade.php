@extends('layouts.app')

@section('content')
    <x-auth-card>
        <div x-data="{ recovery: false }">
            <!-- Title -->
            <h2 class="text-2xl md:text-3xl font-bold text-center text-brand mb-6" x-show="! recovery">
                {{ __('Confirm Access') }}
            </h2>
            <h2 class="text-2xl md:text-3xl font-bold text-center text-brand mb-6" x-cloak x-show="recovery">
                {{ __('Recovery Code') }}
            </h2>

            <div class="mb-6 text-sm text-cocoa/70 text-center" x-show="! recovery">
                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
            </div>

            <div class="mb-6 text-sm text-cocoa/70 text-center" x-cloak x-show="recovery">
                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
            </div>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-4">
                @csrf

                <div x-show="! recovery">
                    <label for="code" class="block text-sm font-semibold text-cocoa/80 mb-1">
                        {{ __('Authentication Code') }}
                    </label>
                    <input id="code" 
                           class="w-full px-4 py-3 rounded-xl border border-cocoa/20 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand/50 transition-colors duration-150" 
                           type="text" 
                           inputmode="numeric" 
                           name="code" 
                           autofocus 
                           x-ref="code" 
                           autocomplete="one-time-code" 
                           placeholder="000000" />
                </div>

                <div x-cloak x-show="recovery">
                    <label for="recovery_code" class="block text-sm font-semibold text-cocoa/80 mb-1">
                        {{ __('Recovery Code') }}
                    </label>
                    <input id="recovery_code" 
                           class="w-full px-4 py-3 rounded-xl border border-cocoa/20 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand/50 transition-colors duration-150" 
                           type="text" 
                           name="recovery_code" 
                           x-ref="recovery_code" 
                           autocomplete="one-time-code" 
                           placeholder="abcdef-12345" />
                </div>

                <div class="flex flex-col space-y-4 mt-6">
                    <button type="submit" 
                            class="w-full px-6 py-3 bg-brand text-white font-semibold rounded-2xl hover:opacity-90 transition-opacity duration-150">
                        {{ __('Log in') }}
                    </button>

                    <div class="text-center">
                        <button type="button" class="text-sm text-cocoa hover:text-brand transition-colors duration-150 underline cursor-pointer font-medium"
                                        x-show="! recovery"
                                        x-on:click="
                                            recovery = true;
                                            $nextTick(() => { $refs.recovery_code.focus() })
                                        ">
                            {{ __('Use a recovery code') }}
                        </button>

                        <button type="button" class="text-sm text-cocoa hover:text-brand transition-colors duration-150 underline cursor-pointer font-medium"
                                        x-cloak
                                        x-show="recovery"
                                        x-on:click="
                                            recovery = false;
                                            $nextTick(() => { $refs.code.focus() })
                                        ">
                            {{ __('Use an authentication code') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </x-auth-card>
@endsection
