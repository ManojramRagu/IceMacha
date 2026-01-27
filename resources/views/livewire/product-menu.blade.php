<div class="min-h-screen bg-blush font-display">
    {{-- Main Container --}}
    <div class="max-w-7xl mx-auto px-4 py-12" x-data="{ activeCategory: 'all' }">
        <h2 class="text-4xl md:text-5xl font-bold text-center text-brand mb-12 tracking-tight">Menu</h2>

        {{-- 1. SPECIAL BUNDLES SECTION (Top Priority) --}}

        @php
            $productsByCategory = $products->where('category.name', '!=', 'Promotions')->groupBy('category.name');
        @endphp

        {{-- 2. CATEGORY FILTER BAR --}}
        <div class="sticky top-4 z-30 bg-blush/95 backdrop-blur-sm py-4 mb-10 -mx-4 px-4 flex justify-center">
            <div class="flex flex-wrap justify-center gap-3 p-1.5 bg-white/50 rounded-full shadow-sm border border-white/60">
                <button @click="activeCategory = 'all'"
                        :class="activeCategory === 'all' ? 'bg-brand text-white shadow-md' : 'text-gray-600 hover:bg-white hover:text-brand'"
                        class="px-5 py-2 rounded-full font-semibold transition-all duration-200 text-sm">
                    All
                </button>
                @foreach($productsByCategory->keys() as $catName)
                    <button @click="activeCategory = '{{ $catName }}'"
                            :class="activeCategory === '{{ $catName }}' ? 'bg-brand text-white shadow-md' : 'text-gray-600 hover:bg-white hover:text-brand'"
                            class="px-5 py-2 rounded-full font-semibold transition-all duration-200 text-sm">
                        {{ $catName }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- 3. PRODUCT GRID BY CATEGORY --}}
        @foreach($productsByCategory as $categoryName => $categoryProducts)
            <div class="mb-16 scroll-mt-28" 
                 x-show="activeCategory === 'all' || activeCategory === '{{ $categoryName }}'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-bold text-cocoa">{{ $categoryName }}</h3>
                    <div class="h-px flex-grow ml-6 bg-cocoa/10"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    @foreach($categoryProducts as $product)
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 group relative border border-sand/20 flex flex-col overflow-hidden">
                            
                            {{-- Product Image --}}
                            <div class="relative h-48 bg-gray-50 overflow-hidden cursor-pointer"
                                 wire:click="selectProduct({{ $product->id }})">
                                <img src="/{{ $product->image_path }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200?text={{ urlencode($product->name) }}';">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors duration-300"></div>
                            </div>

                            {{-- Product Info --}}
                            <div class="p-4 flex flex-col flex-grow">
                                <h4 class="font-bold text-gray-800 mb-1 truncate text-base group-hover:text-brand transition-colors">{{ $product->name }}</h4>
                                <div class="flex items-center justify-between mt-auto pt-3">
                                    <span class="text-brand font-bold">LKR {{ number_format($product->price, 0) }}</span>
                                    <button wire:click.prevent="addToCart({{ $product->id }})"
                                            wire:loading.attr="disabled"
                                            class="bg-gray-100 hover:bg-brand hover:text-white text-gray-600 p-2 rounded-xl transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        {{-- SPECIAL BUNDLES SECTION (Moved to Bottom) --}}
        @if($promotions->isNotEmpty())
            <div class="mt-16 mb-8 pt-10 border-t border-brand/10">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-3xl font-bold text-cocoa">Special Bundles</h3>
                    <div class="h-1 flex-grow ml-8 bg-brand/10 rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($promotions as $promo)
                        <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group flex flex-col h-full border border-sand/30">
                            {{-- Image Container --}}
                            <div class="relative h-56 overflow-hidden">
                                <img src="/{{ $promo->image_path }}" 
                                     alt="{{ $promo->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                     onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=Bundle';">
                                     
                                {{-- Price Badge (Top-Left) --}}
                                <div class="absolute top-4 left-4 bg-brand text-white px-4 py-1.5 rounded-2xl text-sm font-bold shadow-lg z-10">
                                    LKR {{ number_format($promo->price, 0) }}
                                </div>

                                {{-- Overlay --}}
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
                            </div>

                            {{-- Content --}}
                            <div class="p-6 flex flex-col flex-grow relative">
                                <h4 class="text-xl font-bold text-cocoa mb-2 leading-tight">{{ $promo->name }}</h4>
                                <p class="text-gray-500 mb-4 text-xs line-clamp-2">{{ $promo->description }}</p>
                                
                                {{-- Products List --}}
                                <div class="space-y-1.5 mb-6 flex-grow overflow-y-auto max-h-24 scrollbar-thin scrollbar-thumb-brand/20">
                                    @foreach($promo->products as $item)
                                        <div class="flex items-start text-xs text-gray-600">
                                            <svg class="w-3.5 h-3.5 mr-2 text-brand flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            <span class="leading-snug">{{ $item->name }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Order Button --}}
                                <button wire:click.prevent="addToCart({{ $promo->id }}, 'bundle')" 
                                        class="w-full bg-brand text-white font-bold py-3 rounded-2xl hover:bg-brand/90 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 text-sm tracking-wide">
                                    ORDER NOW
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- Product Detail Modal --}}
    @if($showModal && $selectedProduct)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-black/60 transition-opacity backdrop-blur-sm" aria-hidden="true" wire:click="closeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-white/20">
                    <div class="bg-white">
                        <div class="relative h-64 sm:h-72">
                            <img src="/{{ $selectedProduct->image_path }}" class="w-full h-full object-cover">
                            <button wire:click="closeModal" class="absolute top-4 right-4 bg-black/20 hover:bg-black/40 text-white rounded-full p-1 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <div class="p-6 sm:p-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $selectedProduct->name }}</h3>
                            <p class="text-gray-500 mb-6 leading-relaxed">{{ $selectedProduct->description }}</p>
                            
                            <div class="flex items-center justify-between">
                                <div class="text-2xl font-bold text-brand">Rs. {{ number_format($selectedProduct->price, 2) }}</div>
                                <button type="button" wire:click.prevent="addToCart({{ $selectedProduct->id }})" class="inline-flex justify-center rounded-2xl border border-transparent shadow-lg px-8 py-3 bg-brand text-base font-bold text-white hover:bg-opacity-90 transition-all transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Success Toast --}}
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