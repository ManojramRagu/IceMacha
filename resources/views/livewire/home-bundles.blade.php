<div class="py-16 bg-gradient-to-b from-white to-blush/30">
    <div class="max-w-7xl mx-auto px-4">
        
        {{-- Section Title --}}
        <h2 class="text-3xl md:text-5xl font-bold text-center text-cocoa mb-4 tracking-tight drop-shadow-sm font-display">
            Promotions & Seasonal Offers
        </h2>
        
        <div class="flex justify-center mb-12">
            <div class="h-1.5 w-24 bg-brand rounded-full"></div>
        </div>

        @if($promotions->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($promotions as $promo)
                    <div class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden group flex flex-col border border-white/50 backdrop-blur-sm relative transform hover:-translate-y-2">
                        
                        {{-- Image Container --}}
                        <div class="relative h-64 overflow-hidden">
                            <img src="/{{ $promo->image_path }}" 
                                 alt="{{ $promo->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                 onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=Bundle';">
                                 
                            {{-- Price Badge --}}
                            <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-md text-brand px-5 py-2 rounded-full text-lg font-bold shadow-lg z-10 border border-brand/10">
                                LKR {{ number_format($promo->price, 0) }}
                            </div>

                            {{-- Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-60 group-hover:opacity-40 transition-opacity duration-300"></div>
                        </div>

                        {{-- Content --}}
                        <div class="p-8 flex flex-col flex-grow relative bg-white">
                            {{-- Decorative Background Icon --}}
                            <div class="absolute top-4 right-4 text-brand/5">
                                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path></svg>
                            </div>

                            <h4 class="text-2xl font-bold text-gray-800 mb-3 group-hover:text-brand transition-colors">{{ $promo->name }}</h4>
                            <p class="text-gray-500 mb-6 flex-grow leading-relaxed">{{ $promo->description }}</p>
                            
                            {{-- Items Included --}}
                            <div class="mb-8">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Includes:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($promo->products as $item)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-brand/5 text-brand border border-brand/10">
                                            {{ $item->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Order Button --}}
                            <button wire:click.prevent="addToCart({{ $promo->id }}, 'bundle')" 
                                    class="w-full bg-brand text-white font-bold py-4 rounded-xl hover:bg-cocoa shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all duration-300 text-base tracking-wide flex justify-center items-center group-hover:ring-4 ring-brand/20">
                                <span>Buy Now</span>
                                <svg class="w-5 h-5 ml-2 -mr-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">Check back soon for seasonal offers!</p>
            </div>
        @endif
    </div>

    {{-- Success Toast (Identical to ProductMenu) --}}
    <div x-data="{ show: @entangle('showToast') }" 
         x-effect="if(show) setTimeout(() => $wire.set('showToast', false), 3000)"
         x-show="show" 
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed bottom-6 right-6 w-auto max-w-sm bg-brand text-white rounded-2xl shadow-xl pointer-events-auto z-50 flex items-center p-4 gap-3">
        <svg class="h-6 w-6 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-sm font-bold">{{ $toastMessage }}</p>
    </div>
</div>
