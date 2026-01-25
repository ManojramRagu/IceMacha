<div class="min-h-screen bg-gray-50">
    {{-- Hero Section --}}
    <div class="w-full h-48 bg-gradient-to-r from-orange-600 via-orange-500 to-yellow-500 flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-5xl font-bold text-white mb-2">COFFEE TIME</h1>
            <p class="text-white text-lg">100% ARABICA - BEST CHOICE</p>
        </div>
    </div>

    {{-- Menu Section --}}
    <div class="max-w-7xl mx-auto px-4 py-12" x-data="{ activeCategory: 'all' }">
        <h2 class="text-4xl font-bold text-center text-teal-700 mb-8">Menu</h2>

        @php
            $productsByCategory = $products->groupBy('category.name');
        @endphp

        {{-- Filter Bar --}}
        <div class="flex flex-wrap justify-center gap-4 mb-12">
            <button @click="activeCategory = 'all'"
                    :class="activeCategory === 'all' ? 'bg-brand text-white' : 'bg-white text-gray-700 hover:bg-gray-100'"
                    class="px-6 py-2 rounded-full font-semibold shadow-sm transition-all duration-200">
                All
            </button>
            @foreach($productsByCategory->keys() as $catName)
                <button @click="activeCategory = '{{ $catName }}'"
                        :class="activeCategory === '{{ $catName }}' ? 'bg-brand text-white' : 'bg-white text-gray-700 hover:bg-gray-100'"
                        class="px-6 py-2 rounded-full font-semibold shadow-sm transition-all duration-200">
                    {{ $catName }}
                </button>
            @endforeach
        </div>

        @foreach($productsByCategory as $categoryName => $categoryProducts)
            <div class="mb-12" x-show="activeCategory === 'all' || activeCategory === '{{ $categoryName }}'" x-collapse>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-700">{{ $categoryName }}</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    @foreach($categoryProducts as $product)
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-200 relative">
                            {{-- Badges --}}
                            @if(stripos($categoryName, 'Promotion') !== false || stripos($product->name, 'Sale') !== false || $product->price < 1000) 
                                <div class="absolute top-2 right-2 z-10 bg-sand text-cocoa text-xs font-bold px-2 py-1 rounded-full shadow-sm">
                                    @php
                                        // Mock discount logic for demo purposes
                                        $discount = 20;
                                    @endphp
                                    {{ $discount }}% OFF
                                </div>
                            @endif

                            {{-- Product Image --}}
                            <div class="relative h-48 bg-gray-100 rounded-t-lg overflow-hidden cursor-pointer group"
                                 wire:click="selectProduct({{ $product->id }})">
                                <img 
                                    src="/{{ $product->image_path }}" 
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                    onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200/cccccc/666666?text={{ urlencode($product->name) }}';">
                                
                                {{-- Hover Overlay --}}
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300"></div>
                            </div>

                            {{-- Product Info --}}
                            <div class="p-4">
                                <h4 class="font-bold text-gray-900 mb-1 truncate">{{ $product->name }}</h4>
                                <p class="text-sm font-bold text-gray-700 mb-3">LKR {{ number_format($product->price, 0) }}</p>
                                <button 
                                    wire:click.prevent="addToCart({{ $product->id }})"
                                    wire:loading.attr="disabled"
                                    class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium py-2 px-4 rounded-2xl transition-colors disabled:opacity-50">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- Product Detail Modal --}}
    @if($showModal && $selectedProduct)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <div class="mb-4">
                                    <img src="/{{ $selectedProduct->image_path }}" alt="{{ $selectedProduct->name }}" class="w-full h-64 object-cover rounded-lg">
                                </div>
                                <h3 class="text-2xl leading-6 font-bold text-gray-900" id="modal-title">
                                    {{ $selectedProduct->name }}
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-4">
                                        {{ $selectedProduct->description }}
                                    </p>
                                    <p class="text-xl font-bold text-brand">
                                        Rs. {{ number_format($selectedProduct->price, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click.prevent="addToCart({{ $selectedProduct->id }})" class="w-full inline-flex justify-center rounded-2xl border border-transparent shadow-sm px-4 py-2 bg-brand text-base font-medium text-white hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand sm:ml-3 sm:w-auto sm:text-sm">
                            Add to Cart
                        </button>
                        <button type="button" wire:click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-2xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Close
                        </button>
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
         class="fixed bottom-0 right-0 m-6 w-full max-w-sm overflow-hidden bg-green-50 rounded-lg shadow-lg border border-green-200 pointer-events-auto z-50">
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium text-green-800">
                        {{ $toastMessage }}
                    </p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button @click="show = false" class="inline-flex text-gray-400 hover:text-gray-500 focus:outline-none">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    </div>
</div>