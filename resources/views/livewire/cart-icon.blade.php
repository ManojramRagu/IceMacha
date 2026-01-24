<div class="relative inline-flex align-middle">
    <a href="#" class="text-white hover:text-sand transition-colors duration-150 relative">
        <img src="{{ asset('img/icons/cart.svg') }}" alt="Cart" class="w-6 h-6 brightness-0 invert">
        @if($cartCount > 0)
            <span class="absolute -top-2 -right-2 inline-flex items-center justify-center px-1.5 py-0.5 border-2 border-brand rounded-full text-xs font-bold leading-none text-white bg-red-600 shadow-sm">
                {{ $cartCount }}
            </span>
        @endif
    </a>
</div>
