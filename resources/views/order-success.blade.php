<x-app-layout>
    <div class="relative min-h-screen flex items-center justify-center bg-blush overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
             <!-- Top Right Blob -->
            <svg class="absolute -top-20 -right-20 w-96 h-96 text-sand/30 animate-pulse" viewBox="0 0 200 200" fill="currentColor">
                 <path fill-rule="evenodd" d="M110.5 7.9c16.3 3.6 31.8 11.9 44.4 23.4 12.6 11.5 22.3 26.2 27.2 42.5 4.9 16.3 5.1 34.3-1.6 49.3-6.7 15.1-20.3 26.6-35.1 36.9-14.8 10.3-30.8 19.3-48.2 20.8-17.4 1.5-36.2-4.5-50.6-14.8-14.4-10.3-24.4-24.9-29.3-41.8-4.9-16.9-4.7-36.1 3.5-50.9s24.4-25.1 41.3-33C79 32.4 94.2 4.3 110.5 7.9z" clip-rule="evenodd"/>
            </svg>
             <!-- Bottom Left Blob -->
            <svg class="absolute -bottom-20 -left-20 w-80 h-80 text-brand/5" viewBox="0 0 200 200" fill="currentColor">
                <path fill-rule="evenodd" d="M89.7 5.1C107.5 7 127.3 12 143.1 27.6c15.8 15.6 27.7 41.8 28.5 67.2.8 25.4-9.3 50.1-24.5 68.6-15.2 18.5-35.6 30.8-57.9 33.6-22.3 2.8-46.5-3.9-63.5-19.1-17-15.2-26.8-38.9-28.7-62.7-1.9-23.8 4.1-47.7 18.6-64.4C30.1 34.1 53 18.6 71.9 5.1z" clip-rule="evenodd"/>
            </svg>
        </div>

        <div class="relative z-10 w-full max-w-md px-4 sm:px-6">
            <div class="bg-white rounded-3xl shadow-2xl p-8 sm:p-10 text-center relative overflow-hidden">
                 <!-- Confetti Decoration (CSS Dots) -->
                 <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-brand via-sand to-cocoa opacity-50"></div>

                <div class="mb-8 flex justify-center">
                    <div class="relative">
                        <!-- Glow -->
                        <div class="absolute inset-0 bg-brand/10 rounded-full blur-xl animate-pulse"></div>
                        <!-- Icon Circle -->
                        <div class="relative h-24 w-24 bg-brand/5 rounded-full flex items-center justify-center border border-brand/10">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-12 h-12 text-brand">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>
                    </div>
                </div>

                <h1 class="text-3xl font-extrabold text-brand mb-4">Order Confirmed!</h1>
                
                @if(strtoupper($order->payment_method) === 'CASH')
                     <div class="mb-6 flex justify-center">
                         <span class="bg-sand/40 text-cocoa text-sm font-semibold px-4 py-1.5 rounded-full inline-flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                            </svg>
                           Cash on Delivery
                        </span>
                     </div>
                     <p class="text-cocoa/70 mb-8 max-w-xs mx-auto">Your order has been placed. Please have the exact amount ready.</p>
                @else
                     <p class="text-cocoa/70 mb-8">Thank you for your purchase. A confirmation email is on its way.</p>
                @endif
                
                <div class="bg-gray-50 rounded-2xl p-5 mb-8 border border-gray-100">
                    <p class="text-sm text-cocoa/70 uppercase tracking-wide font-medium mb-1">Order Reference</p>
                    <p class="text-2xl font-bold text-brand tracking-tight">#{{ $order->id }}</p>
                </div>

                <div class="space-y-4">
                    <a href="{{ route('my-orders') }}" class="block w-full bg-brand text-white font-bold py-4 rounded-2xl shadow-md hover:bg-brand/90 hover:shadow-lg transition-all duration-200 text-lg">
                        View My Orders
                    </a>
                    
                     <a href="{{ route('menu') }}" class="inline-block text-cocoa font-semibold hover:text-brand hover:underline transition-colors decoration-2 underline-offset-4">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
