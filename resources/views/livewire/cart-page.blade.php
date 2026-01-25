<div class="w-full bg-blush min-h-screen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold text-brand mb-8 text-center md:text-left">Shopping Cart</h1>

        @if($cartItems->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 bg-white rounded-xl shadow-sm text-center">
                <div class="bg-brand/10 p-6 rounded-full mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-brand">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-semibold text-cocoa mb-2">Your cart is empty</h2>
                <p class="text-cocoa/70 mb-8 max-w-sm">Looks like you haven't added anything to your cart yet. Browse our menu to find something delicious!</p>
                <a href="{{ route('menu') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-brand hover:bg-brand/90 transition-colors duration-200 shadow-sm hover:shadow-md">
                    Back to Menu
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items (Left Column) -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 flex flex-col sm:flex-row gap-4 sm:items-center sm:justify-between transition hover:shadow-md" wire:key="item-{{ $item->CartItemId }}">
                            <div class="flex items-center gap-4 flex-1">
                                <div class="shrink-0 overflow-hidden rounded-lg bg-sand/20" style="width: 80px; height: 80px;">
                                     @if($item->product->image_path)
                                        <img src="{{ asset($item->product->image_path) }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover" style="max-width: 100%;">
                                     @else
                                        <div class="w-full h-full flex items-center justify-center text-cocoa/40">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                        </div>
                                     @endif
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-cocoa">{{ $item->product->name }}</h3>
                                    <p class="text-cocoa/60 text-sm">LKR {{ number_format($item->product->price, 2) }}</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto mt-4 sm:mt-0">
                                <!-- Quantity Controls -->
                                <div class="flex items-center bg-slate/30 rounded-lg p-1">
                                    <button wire:click="decrement({{ $item->CartItemId }})" class="p-1.5 text-cocoa hover:text-brand hover:bg-white rounded-md transition-colors disabled:opacity-50" @if($item->Quantity <= 1) disabled @endif>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                                        </svg>
                                    </button>
                                    <span class="w-8 text-center font-medium text-cocoa">{{ $item->Quantity }}</span>
                                    <button wire:click="increment({{ $item->CartItemId }})" class="p-1.5 text-cocoa hover:text-brand hover:bg-white rounded-md transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="text-right min-w-[80px]">
                                    <p class="font-bold text-lg text-brand">LKR {{ number_format($item->product->price * $item->Quantity, 2) }}</p>
                                </div>

                                <button wire:click="removeItem({{ $item->CartItemId }})" class="text-red-400 hover:text-red-600 transition-colors p-2" title="Remove Item">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary (Right Column) -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm p-6 sticky top-6">
                        <h2 class="text-xl font-bold text-cocoa mb-6">Order Summary</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-cocoa/70">
                                <span>Subtotal</span>
                                <span>LKR {{ number_format($total, 2) }}</span>
                            </div>
                            <!-- Add tax or shipping logic here if needed, for now just subtotal -->
                             <div class="flex justify-between text-cocoa/70">
                                <span>Taxes</span>
                                <span>LKR 0.00</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-4 mb-8">
                            <div class="flex justify-between items-end">
                                <span class="text-cocoa font-semibold text-lg">Total</span>
                                <span class="text-3xl font-bold text-cocoa">LKR {{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout') }}" class="block w-full text-center bg-brand text-white font-semibold py-4 rounded-xl shadow-sm hover:bg-brand/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand transition-all duration-200 text-lg">
                            Checkout
                        </a>

                         <div class="mt-6 text-center">
                            <a href="{{ route('menu') }}" class="text-sm text-cocoa/60 hover:text-brand font-medium transition-colors">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
