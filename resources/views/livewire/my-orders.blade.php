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
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden transition hover:shadow-md">
                        <div class="p-6">
                            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-4">
                                <div>
                                    <span class="text-xs font-bold uppercase tracking-wider text-cocoa/40">Order #{{ $order->id }}</span>
                                    <p class="text-sm text-cocoa/60">{{ $order->created_at->format('M d, Y • h:i A') }}</p>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    {{-- Payment Badge --}}
                                    @php
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
                                <span class="text-xl font-bold text-brand">LKR {{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
