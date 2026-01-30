<div class="h-full flex flex-col font-sans">
    
    <!-- Top Nav (Pill Switch) -->
    <div class="flex justify-center mb-8">
        <div class="bg-sand/30 p-1 rounded-full inline-flex relative shadow-inner">
            <button wire:click="setActiveTab('inventory')" 
                class="px-8 py-2 rounded-full text-sm font-bold transition-all duration-300 {{ $activeTab === 'inventory' ? 'bg-brand text-white shadow-md' : 'text-gray-600 hover:text-brand' }}">
                Manage Inventory
            </button>
            <button wire:click="setActiveTab('orders')" 
                class="px-8 py-2 rounded-full text-sm font-bold transition-all duration-300 {{ $activeTab === 'orders' ? 'bg-brand text-white shadow-md' : 'text-gray-600 hover:text-brand' }}">
                Orders / Feedback
            </button>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-12 gap-8 h-full">
        <!-- Sidebar (Left Column - 3 units) -->
        @if($activeTab === 'inventory')
            <div class="col-span-12 md:col-span-3 space-y-6">
                
                <!-- Card 1: Main Categories -->
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4 text-base">Main Category</h3>
                    <div class="flex flex-col gap-2">
                        @foreach(['Beverages', 'Food', 'Promotions'] as $main)
                            <button wire:click="selectMain('{{ $main }}')"
                                class="w-full text-center px-4 py-3 rounded-2xl font-semibold transition-all duration-200 {{ $selectedMain === $main ? 'bg-brand text-white shadow-md' : 'bg-gray-50 text-gray-500 hover:bg-gray-100' }}">
                                {{ $main }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Card 2: Sub-Categories (Hidden for Promotions) -->
                @if($selectedMain !== 'Promotions')
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-900 mb-4 text-base">Sub-Category</h3>
                        <div class="flex flex-wrap gap-2">
                            @forelse($this->subCategories as $category)
                                <button wire:click="selectSub('{{ $category->name }}')"
                                    class="px-4 py-1.5 rounded-full text-xs font-semibold transition-all border {{ $selectedSub === $category->name ? 'bg-sand text-brand border-sand' : 'bg-white text-gray-500 border-gray-200 hover:border-brand hover:text-brand' }}">
                                    {{ $category->name }}
                                </button>
                            @empty
                                <p class="text-xs text-gray-400 italic">Select a main category.</p>
                            @endforelse
                        </div>
                    </div>
                @endif

                <!-- Card 3: Quick Actions -->
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4 text-base">Quick actions</h3>
                    <button wire:click="setMode('create')" 
                        class="w-full py-3 bg-brand text-white font-bold rounded-2xl shadow-lg hover:shadow-xl hover:bg-opacity-90 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-sm">
                        <span>+ Add Product</span>
                    </button>
                </div>

            </div>
        @endif

        <!-- Content Area (Expandable) -->
        <div class="col-span-12 {{ $activeTab === 'inventory' ? 'md:col-span-9' : 'md:col-span-12' }} space-y-6">
            
            <!-- Product List Card -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 min-h-[600px] flex flex-col">
                @if($activeTab === 'inventory')
                    <!-- Header with Search -->
                    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                        <h2 class="text-xl font-bold text-gray-800">
                            Products · <span class="text-brand">{{ $selectedMain }}</span> 
                            @if($selectedSub) <span class="text-gray-400">/</span> {{ $selectedSub }} @endif
                        </h2>
                        
                        <div class="relative w-full md:w-64">
                            <input type="text" wire:model.live="search" placeholder="Search products..." 
                                class="w-full pl-4 pr-10 py-2 rounded-full border border-gray-200 focus:border-brand focus:ring-brand text-sm">
                            <svg class="w-4 h-4 text-gray-400 absolute right-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    @if($mode === 'create')
                        <div class="p-6 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 text-center flex-grow flex flex-col justify-center items-center">
                            <p class="text-gray-500 mb-2">Create Product Form Placeholder</p>
                            <button wire:click="setMode('list')" class="text-brand font-bold hover:underline">Cancel</button>
                        </div>
                    @else
                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-100">
                                        <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider w-12">#</th>
                                        <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Price</th>
                                        <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Stock</th>
                                        <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">ImagePath</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($this->products as $index => $product)
                                        <tr wire:key="product-{{ $product->id }}"
                                            wire:click="editProduct({{ $product->id }})" 
                                            class="hover:bg-gray-50/80 transition-colors group text-sm cursor-pointer {{ $editingProductId === $product->id ? 'bg-sand/30' : '' }}">
                                            <td class="px-4 py-4 text-gray-400 font-mono text-xs">{{ $index + 1 }}</td>
                                            <td class="px-4 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                                            <td class="px-4 py-4 text-gray-600">LKR {{ number_format($product->price, 2) }}</td>
                                            <td class="px-4 py-4 {{ ($product->stock_quantity ?? 0) < 10 ? 'text-red-500 font-bold' : 'text-gray-600' }}">
                                                {{ $product->stock_quantity ?? 'N/A' }}
                                            </td>
                                            <td class="px-4 py-4 text-gray-400 text-xs truncate max-w-[200px] font-mono">
                                                {{ $product->image_path }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">
                                                No products found for this category.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif

                @else
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Orders / Feedback</h2>
                    <p class="text-gray-500">Orders and feedback management content.</p>
                @endif
            </div>

            <!-- Product Detail Card (Editor) -->
            @if($activeTab === 'inventory' && $editingProductId)
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 transform transition-all duration-300">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-gray-800 text-lg">Update / Delete Product</h3>
                        <button wire:click="cancelEdit" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Product Name</label>
                            <input type="text" wire:model="editingName" class="w-full rounded-xl border-gray-200 focus:border-brand focus:ring-brand bg-gray-50">
                            @error('editingName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Price (LKR)</label>
                            <input type="number" step="0.01" wire:model="editingPrice" class="w-full rounded-xl border-gray-200 focus:border-brand focus:ring-brand bg-gray-50">
                            @error('editingPrice') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                            <textarea wire:model="editingDescription" rows="3" class="w-full rounded-xl border-gray-200 focus:border-brand focus:ring-brand bg-gray-50"></textarea>
                            @error('editingDescription') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Stock Quantity</label>
                            <input type="number" wire:model="editingStock" class="w-full rounded-xl border-gray-200 focus:border-brand focus:ring-brand bg-gray-50">
                            @error('editingStock') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-100">
                        <button wire:click="deleteProduct" 
                                onclick="confirm('Are you sure you want to delete this product?') || event.stopImmediatePropagation()"
                                class="px-6 py-2 rounded-full border border-red-200 text-red-600 font-semibold hover:bg-red-50 transition-colors">
                            Delete Product
                        </button>
                        
                        <div class="flex gap-3">
                            <button wire:click="cancelEdit" class="px-6 py-2 rounded-full border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>
                            <button wire:click="saveProduct" class="px-8 py-2 rounded-full bg-brand text-white font-bold shadow-md hover:shadow-lg hover:bg-opacity-90 transition-all transform hover:-translate-y-0.5">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            @elseif($activeTab === 'inventory')
                 <!-- Placeholder Footer when no product selected -->
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 text-center">
                    <p class="text-gray-400 italic">Click on a product row above to edit details.</p>
                </div>
            @endif

        </div>
    </div>

    <!-- Success Toast (Reused from Product Menu) -->
    <div x-data="{ show: @entangle('showToast') }" 
         x-effect="if(show) setTimeout(() => $wire.set('showToast', false), 3000)"
         x-show="show" 
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed bottom-6 right-6 w-auto bg-brand text-white rounded-2xl shadow-xl pointer-events-auto z-50 flex items-center p-4 gap-3">
        <svg class="h-6 w-6 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-sm font-bold" x-text="$wire.toastMessage"></p>
    </div>
</div>
