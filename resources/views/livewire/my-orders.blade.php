<div class="min-h-screen bg-blush py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-cocoa mb-8">My Orders</h1>

        @if($orders->isEmpty())
            <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                <p class="text-cocoa/60 text-lg">You haven't placed any orders yet.</p>
                <a href="{{ route('menu') }}" class="mt-4 inline-block text-brand font-medium hover:underline">Browse Menu</a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div wire:click="viewOrder({{ $order->id }})" class="bg-white rounded-xl shadow-sm overflow-hidden transition hover:shadow-md cursor-pointer hover:border-brand/30 border border-transparent">
                        <div class="p-6">
                            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-4">
                                <div>
                                    <span class="text-xs font-bold uppercase tracking-wider text-cocoa/40">Order #{{ $order->id }}</span>
                                    <p class="text-sm text-cocoa/60">{{ $order->created_at->format('M d, Y • h:i A') }}</p>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    {{-- Payment Badge --}}
                                    @php
                                        // Ensure we access the correct snake_case property
                                        $pm = strtoupper($order->payment_method);
                                    @endphp

                                    @if($pm === 'CARD' || $pm === 'STRIPE')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Paid (Card)
                                        </span>
                                    @elseif($pm === 'CASH')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand/10 text-brand">
                                            Pay on Delivery
                                        </span>
                                    @else
                                         <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $order->payment_method }}
                                        </span>
                                    @endif

                                    {{-- Status Badge (Assuming status exists) --}}
                                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate text-cocoa capitalize">
                                        {{ $order->status }}
                                    </span>
                                </div>
                            </div>

                            <div class="border-t border-gray-100 pt-4 flex justify-between items-center">
                                <span class="font-medium text-cocoa">Total Amount</span>
                                <span class="text-xl font-bold text-brand">Rs. {{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            {{-- Order Details Modal --}}
            @if($showModal && $selectedOrder)
                <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                            
                            {{-- Modal Header --}}
                            <div class="bg-brand px-4 py-4 sm:px-6 flex justify-between items-center">
                                <h3 class="text-lg leading-6 font-bold text-white" id="modal-title">
                                    Order #{{ $selectedOrder->id }} Details
                                </h3>
                                <button wire:click="closeModal" class="text-white/80 hover:text-white transition-colors">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            {{-- Modal Body --}}
                            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4 max-h-[70vh] overflow-y-auto">
                                <div class="space-y-4">
                                    @foreach($selectedOrder->items as $item)
                                        <div class="flex items-center justify-between border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                                            <div class="flex items-center gap-3">
                                                {{-- Determine Name and Image --}}
                                                @php
                                                    $name = "Unavailable product";
                                                    $image = null;
                                                    
                                                    if ($item->product) {
                                                        $name = $item->product->name;
                                                        $image = $item->product->image_path;
                                                    } elseif ($item->promotion) {
                                                        $name = $item->promotion->name . " (Bundle)";
                                                        $image = $item->promotion->image_path;
                                                    }
                                                @endphp
                                                
                                                <div class="h-12 w-12 flex-shrink-0 rounded-lg bg-gray-100 overflow-hidden flex items-center justify-center">
                                                    @if($image)
                                                        <img src="/{{ $image }}" alt="" class="h-full w-full object-cover" onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200?text={{ urlencode($name) }}';">
                                                    @else
                                                        <svg class="h-6 w-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    @endif
                                                </div>

                                                <div>
                                                    <h4 class="text-sm font-bold text-gray-900 {{ $name === 'Unavailable product' ? 'text-red-500 italic' : '' }}">
                                                        {{ $name }}
                                                    </h4>
                                                    <p class="text-xs text-gray-500">
                                                        Qty: {{ $item->quantity }}
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            <div class="text-right">
                                                 <p class="text-sm font-bold text-brand">Rs. {{ number_format($item->price_at_purchase * $item->quantity, 2) }}</p>
                                                 <p class="text-xs text-gray-400">Rs. {{ number_format($item->price_at_purchase, 2) }} / ea</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                             <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse justify-between items-center border-t border-gray-100">
                                <div class="text-xl font-bold text-brand">
                                    Total: Rs. {{ number_format($selectedOrder->total_amount, 2) }}
                                </div>
                                <div class="text-xs text-gray-400 mt-2 sm:mt-0">
                                    {{ $selectedOrder->items->count() }} Items
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
