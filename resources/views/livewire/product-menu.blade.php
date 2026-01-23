<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-8 border-b pb-4">IceMacha Menu</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($products as $product)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-lg transition duration-300">
                    <div class="relative h-48 w-full">
                        <img src="{{ asset($product->image_path) }}" 
                             alt="{{ $product->name }}" 
                             class="absolute inset-0 w-full h-full object-cover">
                    </div>

                    <div class="p-5 flex-grow flex flex-col">
                        <div class="flex items-center justify-between mb-2">
                            <span class="px-2 py-1 text-xs font-medium bg-blue-50 text-blue-600 rounded">
                                {{ $product->category->name }}
                            </span>
                            <span class="text-sm font-semibold text-gray-900">
                                Rs. {{ number_format($product->price, 2) }}
                            </span>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-900 leading-tight mb-2">
                            {{ $product->name }}
                        </h3>
                        
                        <p class="text-gray-500 text-sm line-clamp-2 mb-4">
                            {{ $product->description }}
                        </p>
                        
                        <button class="mt-auto w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition transform active:scale-95">
                            Add to Cart
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>