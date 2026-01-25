<x-app-layout>
    <div class="relative min-h-screen flex items-center justify-center bg-blush">
        <!-- Hero Background with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('img/hero/hero.webp') }}" alt="Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/40"></div>
        </div>

        <div class="relative z-10 w-full max-w-md px-4 sm:px-6">
            <div class="bg-white rounded-xl shadow-2xl p-8 text-center transform transition-all hover:scale-105 duration-300">
                <div class="mb-6 flex justify-center">
                    <div class="h-16 w-16 bg-green-100 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-green-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                </div>

                <h1 class="text-3xl font-bold text-cocoa mb-2">Order Confirmed!</h1>
                <p class="text-cocoa/60 mb-6">Thank you for your purchase.</p>
                
                <div class="bg-sand/20 rounded-lg p-4 mb-8">
                    <p class="text-sm text-cocoa/80 uppercase tracking-wide font-semibold">Order ID</p>
                    <p class="text-2xl font-mono text-brand font-bold">#{{ $orderId }}</p>
                </div>

                <a href="{{ route('my-orders') }}" class="inline-flex w-full items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-brand hover:bg-brand/90 transition-all shadow-md hover:shadow-lg">
                    View My Orders
                </a>
                
                 <a href="{{ route('menu') }}" class="mt-4 inline-block text-sm text-cocoa/60 hover:text-brand font-medium">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
