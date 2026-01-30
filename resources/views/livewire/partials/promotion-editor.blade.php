<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Basic Info -->
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
        <input type="text" wire:model="editingName" class="w-full rounded-xl border-gray-200 focus:border-brand focus:ring-brand bg-gray-50">
        @error('editingName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>
     <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
        <textarea wire:model="editingDescription" rows="3" class="w-full rounded-xl border-gray-200 focus:border-brand focus:ring-brand bg-gray-50"></textarea>
        @error('editingDescription') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>

    <!-- Bundle Items Section -->
    <div class="md:col-span-2 border rounded-xl p-4 bg-gray-50/50">
        <h4 class="font-bold text-gray-800 mb-3">Bundle Items</h4>
        
        <!-- Search to Add -->
        <div class="relative mb-3">
             <input type="text" wire:model.live.debounce.300ms="productSearch" placeholder="Search product to add..." 
                class="w-full pl-4 pr-10 py-2 rounded-full border border-gray-300 focus:border-brand focus:ring-brand text-sm">
             @if(!empty($searchResults))
                <div class="absolute top-10 w-full bg-white border border-gray-100 rounded-xl shadow-lg z-10 overflow-hidden">
                    @foreach($searchResults as $res)
                        <div wire:click="addProductToBundle({{ $res['id'] }})" 
                             class="px-4 py-2 hover:bg-gray-50 cursor-pointer text-sm flex justify-between items-center group">
                            <span>{{ $res['name'] }}</span>
                            <span class="text-gray-500 text-xs group-hover:text-brand">LKR {{ number_format($res['price'], 2) }}</span>
                        </div>
                    @endforeach
                </div>
             @endif
        </div>

        <!-- Items Table -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-gray-500 font-semibold">Product</th>
                        <th class="px-4 py-2 text-gray-500 font-semibold text-right">Price</th>
                        <th class="px-4 py-2 text-gray-500 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($bundleItems as $idx => $bi)
                        <tr>
                            <td class="px-4 py-2">{{ $bi['name'] }}</td>
                            <td class="px-4 py-2 text-right">LKR {{ number_format($bi['price'], 2) }}</td>
                            <td class="px-4 py-2 text-right">
                                <button wire:click="removeProductFromBundle({{ $idx }})" class="text-red-500 hover:text-red-700 text-xs font-bold">Remove</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-4 py-3 text-center text-gray-400 text-xs">No items in bundle yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Price Engine -->
    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4 bg-brand/5 rounded-xl p-4 border border-brand/10">
        <div>
            <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Original Total</label>
            <div class="text-xl font-mono text-gray-700">LKR {{ number_format($this->originalTotal, 2) }}</div>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Discount %</label>
             <input type="number" wire:model.live="discountPercent" min="0" max="100" class="w-full rounded-lg border-gray-200 focus:border-brand focus:ring-brand bg-white text-lg font-bold text-brand">
        </div>
        <div>
             <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Final Bundle Price</label>
             <div class="text-2xl font-bold text-brand">LKR {{ number_format($this->finalPrice, 2) }}</div>
        </div>
    </div>
</div>

<div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-100">
    @if($mode === 'create')
         <button wire:click="setMode('list')" class="px-6 py-2 rounded-full border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition-colors">Cancel</button>
    @else
        <button wire:click="deletePromotion" 
                onclick="confirm('Delete this promotion?') || event.stopImmediatePropagation()"
                class="px-6 py-2 rounded-full border border-red-200 text-red-600 font-semibold hover:bg-red-50 transition-colors">
            Delete
        </button>
    @endif
    
    <div class="flex gap-3">
        @if($mode !== 'create')
         <button wire:click="cancelEdit" class="px-6 py-2 rounded-full border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition-colors">Cancel</button>
        @endif
        <button wire:click="savePromotion" class="px-8 py-2 rounded-full bg-brand text-white font-bold shadow-md hover:shadow-lg hover:bg-opacity-90 transition-all transform hover:-translate-y-0.5">
            {{ $mode === 'create' ? 'Create Bundle' : 'Save Changes' }}
        </button>
    </div>
</div>
