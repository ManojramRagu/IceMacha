<div class="min-h-screen bg-gray-50">
    {{-- Hero Section --}}
    <div class="w-full h-48 bg-gradient-to-r from-orange-600 via-orange-500 to-yellow-500 flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-5xl font-bold text-white mb-2">COFFEE TIME</h1>
            <p class="text-white text-lg">100% ARABICA - BEST CHOICE</p>
        </div>
    </div>

    {{-- Menu Section --}}
    <div class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-4xl font-bold text-center text-teal-700 mb-12">Menu</h2>

        @php
            $productsByCategory = $products->groupBy('category.name');
        @endphp

        @foreach($productsByCategory as $categoryName => $categoryProducts)
            <div class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-700">{{ $categoryName }}</h3>
                    <button class="text-sm text-teal-600 hover:text-teal-800 font-medium">Show More...</button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    @foreach($categoryProducts->take(5) as $product)
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-200">
                            {{-- Product Image --}}
                            <div class="relative h-48 bg-gray-100 rounded-t-lg overflow-hidden">
                                <img 
                                    src="/{{ $product->image_path }}" 
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover"
                                    onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200/cccccc/666666?text={{ urlencode($product->name) }}';">
                            </div>

                            {{-- Product Info --}}
                            <div class="p-4">
                                <h4 class="font-bold text-gray-900 mb-1 truncate">{{ $product->name }}</h4>
                                <p class="text-sm font-bold text-gray-700 mb-3">LKR {{ number_format($product->price, 0) }}</p>
                                <button class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium py-2 px-4 rounded transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- Footer --}}
    <footer class="bg-gray-800 text-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h4 class="font-bold text-lg mb-4">Our Goal</h4>
                <p class="text-sm text-gray-300">IceMacha brings you the finest selection of beverages, snacks, and food items delivered right to your doorstep.</p>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-4">Our Socials</h4>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-blue-400">Instagram</a>
                    <a href="#" class="hover:text-blue-400">Facebook</a>
                    <a href="#" class="hover:text-blue-400">Twitter</a>
                </div>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-4">Legal & Policies</h4>
                <ul class="text-sm text-gray-300 space-y-1">
                    <li>Privacy Policy</li>
                    <li>Terms of Service</li>
                    <li>Refund Policy</li>
                </ul>
            </div>
        </div>
        <div class="text-center mt-8 text-sm text-gray-400">
            © 2025 IceMacha. All rights reserved.
        </div>
    </footer>
</div>