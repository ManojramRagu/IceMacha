<div class="relative inline-flex align-middle">
    <a href="#" class="text-gray-500 hover:text-brand transition-colors duration-150">
        <img src="{{ asset('img/icons/cart.svg') }}" alt="Cart" class="w-6 h-6">
        
        @if($cartCount > 0)
            <span class="absolute -top-2 -right-2 inline-flex items-center justify-center px-1.5 py-0.5 border-2 border-white rounded-full text-xs font-bold leading-none text-white bg-brand shadow-sm">
                {{ $cartCount }}
            </span>
        @endif
    </a>
</div>
