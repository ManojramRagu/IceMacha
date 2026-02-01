<div class="w-full bg-gray-50 min-h-screen font-display">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        {{-- Page Header --}}
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-8 h-8 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h1 class="text-4xl font-bold text-cocoa">Shopping Cart</h1>
            </div>
            <p class="text-gray-500 ml-11">Review your items and proceed to checkout</p>
        </div>

        @if($cartItems->isEmpty())
            {{-- Empty Cart State --}}
            <div class="flex flex-col items-center justify-center py-24 bg-white rounded-3xl shadow-sm text-center">
                <div class="bg-gradient-to-br from-brand/10 to-brand/5 p-8 rounded-full mb-8">
                    <svg class="w-20 h-20 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-cocoa mb-3">Your cart is empty</h2>
                <p class="text-gray-500 mb-10 max-w-md text-lg">Looks like you haven't added anything yet. Start exploring our delicious menu!</p>
                <a href="{{ route('menu') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-brand text-white font-bold rounded-2xl hover:bg-cocoa transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Browse Menu
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                {{-- Cart Items --}}
                <div class="lg:col-span-8 space-y-4">
                    @foreach($cartItems as $item)
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all p-6 group" wire:key="item-{{ $item->CartItemId }}">
                            <div class="flex flex-col md:flex-row gap-6">
                                {{-- Product Image --}}
                                <div class="shrink-0 w-full md:w-32 h-32 rounded-xl overflow-hidden bg-gray-100 group-hover:scale-[1.02] transition-transform">
                                     @php
                                         $imagePath = $item->product ? $item->product->image_path : ($item->promotion ? $item->promotion->image_path : null);
                                         $name = $item->product ? $item->product->name : ($item->promotion ? $item->promotion->name : 'Unknown Item');
                                         $price = $item->product ? $item->product->price : ($item->promotion ? $item->promotion->price : 0);
                                     @endphp
                                     
                                     @if($imagePath)
                                        <img src="{{ asset($imagePath) }}" alt="{{ $name }}" class="w-full h-full object-cover">
                                     @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                     @endif
                                </div>

                                {{-- Product Details --}}
                                <div class="flex-1 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold text-cocoa mb-1">{{ $name }}</h3>
                                        <p class="text-gray-500 text-sm">LKR {{ number_format($price, 0) }} each</p>
                                    </div>

                                    {{-- Controls --}}
                                    <div class="flex items-center gap-6">
                                        {{-- Quantity --}}
                                        <div class="flex items-center bg-gray-100 rounded-xl p-1.5">
                                            <button wire:click="decrement({{ $item->CartItemId }})" 
                                                    class="w-9 h-9 flex items-center justify-center text-gray-500 hover:text-brand hover:bg-white rounded-lg transition-all disabled:opacity-30 disabled:cursor-not-allowed" 
                                                    @if($item->Quantity <= 1) disabled @endif>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                </svg>
                                            </button>
                                            <span class="w-12 text-center font-bold text-cocoa text-lg">{{ $item->Quantity }}</span>
                                            <button wire:click="increment({{ $item->CartItemId }})" 
                                                    class="w-9 h-9 flex items-center justify-center text-gray-500 hover:text-brand hover:bg-white rounded-lg transition-all disabled:opacity-30 disabled:cursor-not-allowed"
                                                    @if($item->product && $item->Quantity >= $item->product->stock_quantity) disabled @endif>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        {{-- Price --}}
                                        <div class="text-right min-w-[100px]">
                                            <p class="text-2xl font-bold text-brand">LKR {{ number_format($price * $item->Quantity, 0) }}</p>
                                        </div>

                                        {{-- Remove --}}
                                        <button wire:click="removeItem({{ $item->CartItemId }})" 
                                                class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all" 
                                                title="Remove">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Order Summary --}}
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-2xl shadow-sm p-8 sticky top-24 border-2 border-gray-100">
                        <h2 class="text-2xl font-bold text-cocoa mb-8">Order Summary</h2>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-gray-600">
                                <span class="text-lg">Subtotal</span>
                                <span class="font-semibold">LKR {{ number_format($total, 0) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span class="text-lg">Taxes & Fees</span>
                                <span class="font-semibold">LKR 0</span>
                            </div>
                        </div>

                        <div class="border-t-2 border-gray-100 pt-6 mb-8">
                            <div class="flex justify-between items-baseline">
                                <span class="text-xl font-bold text-cocoa">Total</span>
                                <span class="text-4xl font-bold text-cocoa">LKR {{ number_format($total, 0) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout') }}" 
                           class="block w-full text-center bg-brand text-white font-bold py-5 rounded-2xl shadow-lg hover:shadow-xl hover:bg-cocoa transition-all transform hover:-translate-y-1 text-lg mb-6">
                            Proceed to Checkout
                        </a>

                        <a href="{{ route('menu') }}" 
                           class="block text-center text-gray-500 hover:text-brand font-semibold transition-colors">
                            ← Continue Shopping
                        </a>

                        {{-- Trust Badges --}}
                        <div class="mt-8 pt-8 border-t border-gray-100">
                            <div class="flex items-center justify-center gap-6 text-gray-400">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm">Secure Payment</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
