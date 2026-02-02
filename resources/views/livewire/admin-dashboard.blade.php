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
                    @php
                        $canCreate = $selectedMain === 'Promotions' || !empty($selectedSub);
                    @endphp
                    <button wire:click="setMode('create')" 
                        @if(!$canCreate) disabled @endif
                        class="w-full py-3 rounded-2xl font-bold transition-all flex items-center justify-center gap-2 text-sm
                        {{ $canCreate ? 'bg-brand text-white shadow-lg hover:shadow-xl hover:bg-opacity-90 transform hover:-translate-y-0.5' : 'bg-gray-200 text-gray-400 cursor-not-allowed' }}">
                        <span>+ Add Product</span>
                    </button>
                </div>

            </div>
        @endif

        <div class="col-span-12 {{ $activeTab === 'inventory' ? 'md:col-span-9' : 'md:col-span-12' }} space-y-6">
            
            <!-- List/Create Card -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-4 md:p-8 min-h-[600px] flex flex-col">
                @if($activeTab === 'inventory')
                    <!-- Header with Search -->
                    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                        <h2 class="text-xl font-bold text-gray-800">
                            {{ $selectedMain === 'Promotions' ? 'Promotions' : 'Products' }} · <span class="text-brand">{{ $selectedMain }}</span> 
                            @if($selectedSub) <span class="text-gray-400">/</span> {{ $selectedSub }} @endif
                        </h2>
                        
                        <div class="relative w-full md:w-64">
                            <input type="text" wire:model.live="search" placeholder="Search..." 
                                class="w-full pl-4 pr-10 py-2 rounded-full border border-gray-200 focus:border-brand focus:ring-brand text-sm">
                            <svg class="w-4 h-4 text-gray-400 absolute right-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    @if($mode === 'create')
                        @if($selectedMain === 'Promotions')
                            <!-- Create Promotion Form -->
                            <div class="flex flex-col h-full">
                                <h3 class="font-bold text-lg mb-4">Create New Bundle</h3>
                                @include('livewire.partials.promotion-editor')
                            </div>
                        @else
                            <div class="h-full flex flex-col">
                                <h3 class="font-bold text-gray-800 text-lg mb-6">Create New Product</h3>
                                
                                <div class="flex-grow overflow-y-auto pr-2 space-y-6">
                                    <div class="space-y-4">
                                        <!-- Image Upload -->
                                        <div>
                                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Product Image</label>
                                            <div class="flex items-center gap-4">
                                                <div class="w-24 h-24 rounded-2xl bg-gray-100 border border-gray-200 flex items-center justify-center overflow-hidden">
                                                    @if ($newImage)
                                                        <img src="{{ $newImage->temporaryUrl() }}" class="w-full h-full object-cover">
                                                    @else
                                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    @endif
                                                </div>
                                                <div class="flex-grow">
                                                    <input type="file" wire:model.live="newImage" id="productImage" class="hidden">
                                                    <label for="productImage" class="cursor-pointer inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl font-semibold text-xs text-gray-600 hover:bg-gray-50 transition-colors">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                                        Choose File
                                                    </label>
                                                    <p class="mt-2 text-[10px] text-gray-400">PNG, JPG up to 2MB</p>
                                                </div>
                                            </div>
                                            @error('newImage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>

                                        <!-- Fields -->
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Name</label>
                                                <input type="text" wire:model="editingName" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2 focus:ring-2 focus:ring-brand focus:border-transparent outline-none transition-all">
                                                @error('editingName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Price (LKR)</label>
                                                <input type="number" wire:model="editingPrice" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2 focus:ring-2 focus:ring-brand focus:border-transparent outline-none transition-all">
                                                @error('editingPrice') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Stock</label>
                                                <input type="number" wire:model="editingStock" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2 focus:ring-2 focus:ring-brand focus:border-transparent outline-none transition-all">
                                                @error('editingStock') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Category</label>
                                                <div class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2 text-gray-500">
                                                    {{ $selectedMain }} / {{ $selectedSub ?: 'Select Sub...' }}
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Description</label>
                                            <textarea wire:model="editingDescription" rows="3" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2 focus:ring-2 focus:ring-brand focus:border-transparent outline-none transition-all resize-none"></textarea>
                                            @error('editingDescription') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
                                    <button wire:click="setMode('list')" class="px-6 py-2 rounded-xl text-gray-500 hover:bg-gray-50 font-bold transition-colors">Cancel</button>
                                    <button wire:click="storeProduct" class="px-8 py-2 rounded-xl bg-brand text-white font-bold shadow-lg hover:shadow-xl hover:bg-opacity-90 transition-all transform hover:-translate-y-0.5">
                                        Create Product
                                    </button>
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-100">
                                        <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider w-12">#</th>
                                        <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Price</th>
                                        @if($selectedMain === 'Promotions')
                                            <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Discount</th>
                                            <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Items</th>
                                        @else
                                            <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Stock</th>
                                        @endif
                                        <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">ImagePath</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($this->products as $index => $item)
                                        <tr wire:key="item-{{ $item->id }}"
                                            wire:click="editProduct({{ $item->id }})" 
                                            class="hover:bg-gray-50/80 transition-colors group text-sm cursor-pointer {{ ($editingProductId === $item->id || $editingPromotionId === $item->id) ? 'bg-sand/30' : '' }}">
                                            <td class="px-4 py-4 text-gray-400 font-mono text-xs">{{ $index + 1 }}</td>
                                            <td class="px-4 py-4 font-medium text-gray-900">{{ $item->name }}</td>
                                            <td class="px-4 py-4 text-gray-600 font-bold">{{ $item->price }}</td>
                                            
                                            @if($selectedMain === 'Promotions')
                                                <td class="px-4 py-4 text-green-600 font-bold">{{ $item->discount_percent }}%</td>
                                                <td class="px-4 py-4 text-gray-500 text-xs">{{ $item->products->count() }} Items</td>
                                            @else
                                                <td class="px-4 py-4 {{ ($item->stock_quantity ?? 0) < 10 ? 'text-red-500 font-bold' : 'text-gray-600' }}">
                                                    {{ $item->stock_quantity ?? 'N/A' }}
                                                </td>
                                            @endif
                                            
                                            <td class="px-4 py-4 text-gray-400 text-xs truncate max-w-[200px] font-mono">
                                                {{ $item->image_path }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">
                                                No items found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif

                @else
                    <div class="space-y-8">
                    <div class="space-y-8">
                        <!-- Active Orders Table -->
                        <div wire:poll.10s>
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                                    Active Orders (Pending)
                                    <span class="flex h-2 w-2 relative">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-yellow-500"></span>
                                    </span>
                                </h2>
                            </div>

                            <div class="overflow-x-auto rounded-2xl border border-gray-100 mb-8 bg-white shadow-sm">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-gray-50 text-gray-500 font-bold uppercase text-xs">
                                        <tr>
                                            <th class="px-6 py-4">#</th>
                                            <th class="px-6 py-4">User</th>
                                            <th class="px-6 py-4">Total</th>
                                            <th class="px-6 py-4">Status</th>
                                            <th class="px-6 py-4">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @forelse($this->activeOrders as $order)
                                            <tr wire:click="viewOrder({{ $order->id }})" class="hover:bg-brand/5 cursor-pointer transition-colors group">
                                                <td class="px-6 py-4 font-mono text-xs font-bold text-brand">#{{ $order->id }}</td>
                                                <td class="px-6 py-4 font-medium text-gray-900">{{ $order->user->name ?? 'Guest' }}</td>
                                                <td class="px-6 py-4 font-bold text-gray-800">LKR {{ number_format($order->total_amount, 2) }}</td>
                                                <td class="px-6 py-4">
                                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase bg-yellow-100 text-yellow-700 shadow-sm">
                                                        {{ $order->status }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-gray-400 text-xs">{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">No active orders found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Completed Orders Table -->
                        <div>
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                                    Completed Orders
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                </h2>
                            </div>

                            <div class="overflow-x-auto rounded-2xl border border-gray-100 mb-8 bg-white shadow-sm opacity-90">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-gray-50 text-gray-500 font-bold uppercase text-xs">
                                        <tr>
                                            <th class="px-6 py-4">#</th>
                                            <th class="px-6 py-4">User</th>
                                            <th class="px-6 py-4">Total</th>
                                            <th class="px-6 py-4">Status</th>
                                            <th class="px-6 py-4">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @forelse($this->completedOrders as $order)
                                            <tr wire:click="viewOrder({{ $order->id }})" class="hover:bg-gray-50 cursor-pointer transition-colors">
                                                <td class="px-6 py-4 font-mono text-xs text-gray-500">#{{ $order->id }}</td>
                                                <td class="px-6 py-4 font-medium text-gray-600">{{ $order->user->name ?? 'Guest' }}</td>
                                                <td class="px-6 py-4 font-bold text-gray-600">LKR {{ number_format($order->total_amount, 2) }}</td>
                                                <td class="px-6 py-4">
                                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase bg-green-100 text-green-700 shadow-sm">
                                                        {{ $order->status }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-gray-400 text-xs">{{ $order->created_at->format('M d, Y') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">No completed orders found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Order Detail Modal -->
                        @if($viewingOrder)
                            <div class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-black/60 backdrop-blur-md" wire:click.self="closeOrderView">
                                <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg overflow-hidden animate-in fade-in zoom-in duration-300 relative">
                                    
                                    <!-- Modal Header -->
                                    <div class="relative h-32 bg-brand overflow-hidden">
                                        <div class="absolute inset-0 bg-black/20"></div>
                                        
                                        <button wire:click="closeOrderView" class="absolute top-4 right-4 p-2 bg-white/20 hover:bg-white/40 rounded-full text-white transition-colors z-10">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                        
                                        <div class="absolute bottom-6 left-8 text-white">
                                            <p class="text-xs uppercase tracking-widest opacity-80 font-bold mb-1">Order Details</p>
                                            <h2 class="text-3xl font-display font-bold">#{{ $viewingOrder->id }}</h2>
                                        </div>
                                    </div>

                                    <!-- Modal Content -->
                                    <div class="p-8 max-h-[60vh] overflow-y-auto">
                                        <!-- User Info -->
                                        <div class="flex items-center gap-4 mb-8">
                                            <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center text-xl">
                                                ☕
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-gray-900 text-lg">{{ $viewingOrder->user->name ?? 'Guest User' }}</h3>
                                                <p class="text-gray-500 text-sm">{{ $viewingOrder->user->email ?? 'N/A' }}</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <span class="block px-3 py-1 rounded-full text-xs font-bold uppercase mb-1 {{ $viewingOrder->status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                                    {{ $viewingOrder->status }}
                                                </span>
                                                <p class="text-xs text-gray-400">{{ $viewingOrder->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>

                                        <!-- Order Items -->
                                        <div class="space-y-4 mb-8">
                                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Items Ordered</p>
                                            @foreach($viewingOrder->items as $item)
                                                <div class="flex justify-between items-center py-2 border-b border-gray-50 last:border-0">
                                                    <div class="flex items-center gap-3">
                                                        <span class="w-6 h-6 rounded-full bg-sand/30 text-cocoa text-xs font-bold flex items-center justify-center">
                                                            {{ $item->quantity }}x
                                                        </span>
                                                        <span class="text-gray-700 font-medium">{{ $item->product->name ?? 'Unknown Item' }}</span>
                                                    </div>
                                                    <span class="font-bold text-gray-900">
                                                        {{ number_format(($item->price_at_purchase ?? $item->product->price ?? 0) * $item->quantity, 2) }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Total -->
                                        <div class="flex justify-between items-center pt-6 border-t border-gray-100 mb-8">
                                            <span class="text-lg font-bold text-gray-500">Total Amount</span>
                                            <span class="text-2xl font-bold text-brand">LKR {{ number_format($viewingOrder->total_amount, 2) }}</span>
                                        </div>

                                        <!-- Actions -->
                                        @if($viewingOrder->status === 'pending')
                                            <button wire:click="markAsPaid({{ $viewingOrder->id }})" 
                                                class="w-full py-4 rounded-xl bg-brand text-white font-bold text-lg shadow-lg hover:bg-opacity-90 hover:shadow-xl transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Mark as PAID
                                            </button>
                                            <p class="text-center text-xs text-gray-400 mt-3">This action cannot be undone.</p>
                                        @else
                                            <div class="w-full py-4 rounded-xl bg-gray-100 text-gray-400 font-bold text-lg flex items-center justify-center gap-2 cursor-not-allowed">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Order Completed
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Feedback Table -->
                        <div>
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-xl font-bold text-gray-800">Feedback & Inquiries</h2>
                            </div>

                            <div class="overflow-x-auto rounded-2xl border border-gray-100">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-gray-50 text-gray-500 font-bold uppercase text-xs">
                                        <tr>
                                            <th class="px-6 py-4">Status</th>
                                            <th class="px-6 py-4">Name</th>
                                            <th class="px-6 py-4">Subject</th>
                                            <th class="px-6 py-4">Date</th>
                                            <th class="px-6 py-4 text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @forelse($this->messages as $msg)
                                            <tr class="hover:bg-gray-50/50 transition-colors">
                                                <td class="px-6 py-4">
                                                    @if(!$msg->is_read)
                                                        <span class="px-2 py-1 rounded-full bg-brand text-white text-[10px] font-bold">NEW</span>
                                                    @else
                                                        <span class="text-gray-400 text-xs">Read</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 font-medium text-gray-900">{{ $msg->name }}</td>
                                                <td class="px-6 py-4 text-gray-600 truncate max-w-[200px]">{{ $msg->subject }}</td>
                                                <td class="px-6 py-4 text-gray-400 text-xs">{{ optional($msg->created_at)->diffForHumans() ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 text-right flex justify-end gap-2">
                                                    <button wire:click="viewMessage({{ $msg->id }})" class="px-4 py-1.5 rounded-full border border-gray-200 text-gray-600 hover:bg-gray-50 text-xs font-semibold">View</button>
                                                    <button wire:click="confirmDelete('message', {{ $msg->id }})" 
                                                            class="px-4 py-1.5 rounded-full border border-red-100 text-red-500 hover:bg-red-50 text-xs font-semibold">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">No feedback messages found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Message View Modal -->
                    @if($viewingMessage)
                        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" wire:click.self="closeMessage">
                            <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
                                <div class="p-8">
                                    <div class="flex justify-between items-start mb-6">
                                        <div>
                                            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $viewingMessage->subject }}</h3>
                                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                                <span class="font-semibold text-brand">{{ $viewingMessage->name }}</span>
                                                <span>&lt;{{ $viewingMessage->email }}&gt;</span>
                                                <span>•</span>
                                                <span>{{ optional($viewingMessage->CreatedAt)->format('M d, Y h:i A') ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                        <button wire:click="closeMessage" class="p-2 rounded-full hover:bg-gray-100 text-gray-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                    
                                    <div class="bg-gray-50 rounded-xl p-6 text-gray-700 leading-relaxed whitespace-pre-wrap min-h-[150px]">
                                        {{ $viewingMessage->message }}
                                    </div>

                                    <div class="mt-8 flex justify-end">
                                        <button wire:click="closeMessage" class="px-6 py-2 rounded-full bg-brand text-white font-bold hover:bg-opacity-90">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            <!-- Editor Section -->
            @if($activeTab === 'inventory')
                @if($editingProductId)
                    <!-- Product Editor -->
                    <!-- Product Editor -->
                    <div x-data x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'center' })" class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 transform transition-all duration-300">
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
                @elseif($editingPromotionId)
                    <!-- Promotion Editor -->
                    <!-- Promotion Editor -->
                    <div x-data x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'center' })" class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 transform transition-all duration-300">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-bold text-gray-800 text-lg">Update / Delete Promotion</h3>
                             <button wire:click="cancelEdit" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        @include('livewire.partials.promotion-editor')
                    </div>
                @elseif($activeTab === 'inventory')
                     <!-- Placeholder Footer when no product selected -->
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 text-center w-full">
                        <p class="text-gray-400 italic">Click on a row above to edit details.</p>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Confirmation Modal -->
    @if($confirmingDelete)
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" wire:click.self="cancelDelete">
            <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-sm overflow-hidden animate-bounce-in p-8 text-center">
                
                <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6 text-red-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                
                <h3 class="text-2xl font-bold font-display text-gray-900 mb-2">Are you sure?</h3>
                <p class="text-gray-500 mb-8">
                    Do you really want to delete this {{ $deleteType }}? This process cannot be undone.
                </p>
                
                <div class="flex gap-3 justify-center">
                    <button wire:click="cancelDelete" class="px-6 py-3 rounded-xl border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition-colors w-full">
                        Cancel
                    </button>
                    <button wire:click="performDelete" class="px-6 py-3 rounded-xl bg-red-500 text-white font-bold shadow-lg hover:shadow-xl hover:bg-red-600 transition-all transform hover:-translate-y-0.5 w-full">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    @endif

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
