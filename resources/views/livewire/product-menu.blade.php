<div class="min-h-screen bg-gray-50 font-display">
    
    {{-- HERO SECTION --}}
    <div class="relative h-[400px] overflow-hidden">
        {{-- Background Image --}}
        <img src="{{ asset('img/menu/hero.webp') }}" class="absolute inset-0 w-full h-full object-cover" alt="Menu">
        
        {{-- Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-gray-50"></div>
        
        {{-- Decorative Top Border --}}
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-brand to-transparent"></div>
        
        {{-- Content --}}
        <div class="relative h-full flex flex-col items-center justify-center text-center px-4 max-w-4xl mx-auto">
            {{-- Decorative Line --}}
            <div class="w-16 h-px bg-brand mb-6"></div>
            
            {{-- Main Title --}}
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 tracking-tight leading-tight font-display">
                Our Curated Menu
            </h1>
            
            {{-- Subtitle --}}
            <p class="text-lg md:text-xl text-white/90 font-light mb-8 max-w-2xl leading-relaxed">
                Handcrafted beverages and artisanal treats, made fresh daily with passion and precision
            </p>
            
            {{-- Decorative Line --}}
            <div class="w-16 h-px bg-brand"></div>
        </div>
        
        {{-- Scroll Indicator --}}
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </div>

    {{-- Main Container --}}
    <div class="max-w-7xl mx-auto px-4 py-8 -mt-20 relative z-10" x-data="{ activeCategory: 'all' }">

        @php
            $productsByCategory = $products->where('category.name', '!=', 'Promotions')
                ->groupBy(function($item) {
                    return $item->subCategory ? $item->subCategory->name : 'Others';
                })->sortKeys();
        @endphp

        {{-- 1. STICKY CATEGORY FILTER --}}
        <div class="sticky top-24 z-30 mb-12 flex justify-center pointer-events-none"> <!-- precise top spacing -->
            <div class="pointer-events-auto bg-white/80 backdrop-blur-md px-2 py-2 rounded-full shadow-lg border border-white/40 flex flex-wrap justify-center gap-1.5 transition-all duration-300 hover:bg-white/95">
                <button @click="activeCategory = 'all'"
                        :class="activeCategory === 'all' ? 'bg-brand text-white shadow-md' : 'text-gray-500 hover:bg-gray-100 hover:text-brand'"
                        class="px-6 py-2.5 rounded-full font-bold transition-all duration-300 text-sm">
                    All
                </button>
                @foreach($productsByCategory->keys() as $catName)
                    <button @click="activeCategory = '{{ $catName }}'"
                            :class="activeCategory === '{{ $catName }}' ? 'bg-brand text-white shadow-md' : 'text-gray-500 hover:bg-gray-100 hover:text-brand'"
                            class="px-6 py-2.5 rounded-full font-bold transition-all duration-300 text-sm">
                        {{ $catName }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- 2. PRODUCT GRID --}}
        @foreach($productsByCategory as $categoryName => $categoryProducts)
            <div class="mb-20 scroll-mt-40" 
                 x-show="activeCategory === 'all' || activeCategory === '{{ $categoryName }}'" 
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-y-8"
                 x-transition:enter-end="opacity-100 translate-y-0">
                
                <div class="flex items-end gap-6 mb-8">
                    <h3 class="text-3xl font-bold text-cocoa leading-none">{{ $categoryName }}</h3>
                    <div class="h-px flex-grow bg-gradient-to-r from-cocoa/20 to-transparent mb-1.5"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @foreach($categoryProducts as $product)
                        <div class="group bg-white rounded-[2rem] shadow-sm hover:shadow-2xl transition-all duration-500 cursor-pointer overflow-hidden flex flex-col items-center text-center relative hover:-translate-y-2"
                             wire:click="selectProduct({{ $product->id }})">
                            
                            {{-- Image Area --}}
                            <div class="relative w-full aspect-[4/5] overflow-hidden bg-gray-100">
                                <img src="/{{ $product->image_path }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                     onerror="this.onerror=null; this.src='https://via.placeholder.com/400x500?text={{ urlencode($product->name) }}';">
                                
                                {{-- Gradient Overlay --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                {{-- Badges --}}
                                @if($product->stock_quantity <= 5)
                                    <div class="absolute top-4 right-4 animate-pulse">
                                        <span class="px-3 py-1 bg-orange-500 text-white rounded-lg text-xs font-bold shadow-lg">
                                            Low Stock
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="p-6 w-full flex flex-col flex-grow">
                                <h4 class="text-xl font-bold text-cocoa mb-2 leading-tight group-hover:text-brand transition-colors">{{ $product->name }}</h4>
                                <div class="mt-auto pt-2">
                                     <span class="text-brand font-bold text-lg">{{ $product->formatted_price }}</span>
                                </div>
                            </div>

                            {{-- Quick Add Button (Visible on Hover/Desktop) --}}
                            @if($product->stock_quantity > 0)
                                <button wire:click.stop="addToCart({{ $product->id }}, 'product', 1)"
                                        class="absolute bottom-6 right-6 w-10 h-10 bg-white text-brand rounded-full shadow-lg flex items-center justify-center opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-300 hover:bg-brand hover:text-white z-20"
                                        title="Quick Add">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        {{-- 3. SPECIAL OFFERS (DISTINCT SECTION) --}}
        @if($promotions->isNotEmpty())
            <div class="mt-24 relative">
                <div class="absolute inset-0 bg-cocoa/5 -mx-4 md:-mx-8 rounded-[3rem] transform -skew-y-1"></div>
                <div class="relative py-16 px-4">
                    <div class="text-center mb-12">
                        <span class="text-brand font-bold uppercase tracking-widest text-xs mb-2 block">Limited Time</span>
                        <h3 class="text-3xl md:text-4xl font-bold text-cocoa">Special Bundles & Offers</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($promotions as $promo)
                            <div class="group bg-white rounded-[2rem] p-4 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col border border-white/50">
                                <div class="relative h-56 rounded-[1.5rem] overflow-hidden mb-6 filter group-hover:brightness-105 transition-all">
                                    <img src="/{{ $promo->image_path }}" 
                                         class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                                         onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=Bundle';">
                                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm text-brand px-4 py-1.5 rounded-xl text-sm font-bold shadow-sm">
                                        LKR {{ number_format($promo->price, 0) }}
                                    </div>
                                </div>
                                <div class="px-2 pb-4 flex flex-col flex-grow">
                                    <h4 class="text-2xl font-bold text-cocoa mb-2">{{ $promo->name }}</h4>
                                    <p class="text-gray-500 text-sm mb-6 line-clamp-2 leading-relaxed">{{ $promo->description }}</p>
                                    
                                    <button wire:click.prevent="addToCart({{ $promo->id }}, 'bundle')" 
                                            class="mt-auto w-full py-3.5 rounded-2xl bg-cocoa text-white font-bold hover:bg-brand transition-colors shadow-lg hover:shadow-xl hover:-translate-y-1 transform duration-200">
                                        Order Bundle
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- 4. PRODUCT DETAIL MODAL --}}
    @if($showModal && $selectedProduct)
        <div class="fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" aria-hidden="true" wire:click="closeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-white/20">
                    <div class="flex flex-col md:flex-row h-full md:h-[600px]">
                        
                        {{-- Modal Image --}}
                        <div class="md:w-1/2 h-64 md:h-full relative bg-gray-100">
                            <img src="/{{ $selectedProduct->image_path }}" class="w-full h-full object-cover">
                            <button wire:click="closeModal" class="absolute top-6 left-6 bg-white/20 hover:bg-white/40 backdrop-blur-md text-white rounded-full p-2 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        {{-- Modal Content --}}
                        <div class="md:w-1/2 p-10 md:p-12 flex flex-col justify-center bg-white">
                            <div x-data="{ 
                                modalQty: 1, 
                                stock: {{ $selectedProduct->stock_quantity }},
                                inCart: {{ $quantityInCart }},
                                limit: 10,
                                get maxAllowed() { 
                                    return Math.max(0, Math.min(this.stock, this.limit) - this.inCart);
                                },
                                increment() { if(this.modalQty < this.maxAllowed) this.modalQty++ },
                                decrement() { if(this.modalQty > 1) this.modalQty-- },
                                validateQty() {
                                    if (this.modalQty > this.maxAllowed) this.modalQty = this.maxAllowed;
                                    if (this.modalQty < 1 && this.maxAllowed > 0) this.modalQty = 1;
                                }
                            }" x-init="validateQty()">
                                
                                <span class="text-brand font-bold uppercase tracking-widest text-xs mb-3 block">{{ $selectedProduct->category->name }}</span>
                                <h3 class="text-4xl font-bold text-cocoa mb-4 leading-tight">{{ $selectedProduct->name }}</h3>
                                <p class="text-gray-500 mb-8 text-lg leading-relaxed">{{ $selectedProduct->description }}</p>
                                
                                <div class="flex items-center gap-6 mb-10">
                                    <div class="text-3xl font-bold text-cocoa">{{ $selectedProduct->formatted_price }}</div>
                                    @if($selectedProduct->stock_quantity <= 5 && $selectedProduct->stock_quantity > 0)
                                        <div class="text-orange-500 font-bold text-sm bg-orange-50 px-3 py-1 rounded-lg">
                                            Running Low!
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex flex-col gap-4">
                                    <template x-if="maxAllowed > 0">
                                        <div class="space-y-6">
                                            {{-- Stepper --}}
                                            <div class="flex items-center gap-6">
                                                <span class="text-gray-400 font-bold uppercase text-xs tracking-wider">Quantity</span>
                                                <div class="flex items-center bg-gray-100 rounded-2xl p-1.5 w-fit">
                                                    <button @click="decrement()" class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-brand hover:bg-white rounded-xl transition-all shadow-sm">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                                    </button>
                                                    <input type="number" x-model.number="modalQty" class="w-12 text-center bg-transparent border-none font-bold text-lg p-0 focus:ring-0" readonly>
                                                    <button @click="increment()" class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-brand hover:bg-white rounded-xl transition-all shadow-sm" :class="{'opacity-50 cursor-not-allowed': modalQty >= maxAllowed}">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                    </button>
                                                </div>
                                            </div>

                                            <button wire:click.prevent="addToCart({{ $selectedProduct->id }}, 'product', modalQty)" 
                                                    class="w-full py-5 rounded-2xl bg-brand text-white font-bold text-lg hover:bg-cocoa transition-all shadow-xl hover:shadow-2xl hover:-translate-y-1">
                                                Add to Cart - Rs. <span x-text="(modalQty * {{ $selectedProduct->price }}).toLocaleString()"></span>
                                            </button>
                                        </div>
                                    </template>
                                    
                                    <template x-if="maxAllowed <= 0">
                                        <div class="w-full py-4 bg-gray-100 text-gray-400 font-bold rounded-2xl text-center cursor-not-allowed uppercase tracking-wider">
                                            <span x-text="inCart >= limit ? 'Max Limit Reached' : 'Currently Unavailable'"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Toast Notification --}}
    <div x-data="{ show: @entangle('showToast'), type: @entangle('toastType') }" 
         x-effect="if(show) setTimeout(() => $wire.set('showToast', false), 3500)"
         x-show="show" 
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed bottom-6 right-6 z-50">
        <div :class="{
                'bg-brand text-white': type === 'success',
                'bg-white text-orange-600 border-2 border-orange-200': type === 'warning',
                'bg-white text-red-600 border-2 border-red-200': type === 'error'
             }" 
             class="rounded-2xl shadow-2xl px-6 py-4 flex items-center gap-4">
             
             {{-- Icon --}}
             <div :class="{
                     'bg-white/20': type === 'success',
                     'bg-orange-100': type === 'warning',
                     'bg-red-100': type === 'error'
                  }" 
                  class="w-8 h-8 rounded-full flex items-center justify-center shrink-0">
                  
                  {{-- Success Icon --}}
                  <svg x-show="type === 'success'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  
                  {{-- Warning Icon --}}
                  <svg x-show="type === 'warning'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                  </svg>
                  
                  {{-- Error Icon --}}
                  <svg x-show="type === 'error'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
             </div>
             
             {{-- Message --}}
             <div>
                 <p class="font-bold text-sm" x-text="type === 'success' ? 'Success' : (type === 'warning' ? 'Warning' : 'Error')"></p>
                 <p :class="{
                        'text-white/80': type === 'success',
                        'text-orange-500': type === 'warning',
                        'text-red-500': type === 'error'
                     }" 
                    class="text-xs">{{ $toastMessage }}</p>
             </div>
        </div>
    </div>
</div>