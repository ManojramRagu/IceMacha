<x-app-layout>
    <div class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Hero Background with Overlay -->
        <div class="absolute inset-0 z-0">
             <img src="{{ asset('img/hero/hero.webp') }}" alt="Background" class="w-full h-full object-cover">
             <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
        </div>

        <div class="relative z-10 w-full max-w-md px-4 sm:px-6 py-12">
            <div class="bg-white rounded-3xl shadow-2xl p-10 sm:p-14 text-center relative overflow-hidden">
                
                <div class="mb-6 flex justify-center">
                    <div class="h-20 w-20 bg-brand/10 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-10 h-10 text-brand">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                </div>

                <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Order Confirmed!</h1>
                
                @if(strtoupper($order->payment_method) === 'CASH')
                     <div class="flex justify-center mb-6 mt-3">
                         <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-sand/40 text-cocoa">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-brand">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                            </svg>
                            Cash on Delivery
                        </span>
                     </div>
                     <p class="text-cocoa text-base mb-8 px-4">Your order has been placed. Please have the exact amount ready.</p>
                @else
                     <p class="text-cocoa/70 mb-8 mt-2">Thank you for your purchase. We've received your order.</p>
                @endif
                
                <div class="bg-gray-50 rounded-xl p-4 mb-8 ring-1 ring-black/5">
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Order Reference</p>
                    <p class="text-2xl font-bold text-gray-900">#{{ $order->id }}</p>
                </div>

                <div class="space-y-4">
                    <a href="{{ route('my-orders') }}" class="block w-full bg-brand text-white font-bold py-3.5 rounded-2xl shadow-md hover:bg-brand/90 hover:shadow-lg transition-all duration-200 text-lg">
                        View My Orders
                    </a>
                    
                    <a href="{{ route('menu') }}" class="inline-block text-cocoa/70 font-medium hover:text-brand hover:underline transition-colors decoration-2 underline-offset-4 text-sm">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
