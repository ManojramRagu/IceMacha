<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Livewire\Attributes\On;

class CartIcon extends Component
{
    public $cartCount = 0;

    public function mount()
    {
        $this->updateCartCount();
    }

    #[On('cartUpdated')] 
    public function updateCartCount()
    {
        if (Auth::check()) {
            $cart = Cart::where('UserId', Auth::id())->with('items')->first();
            if ($cart) {
                // Sum of quantities
                $this->cartCount = $cart->items->sum('Quantity');
            } else {
                $this->cartCount = 0;
            }
        } else {
            $this->cartCount = 0;
        }
    }

    public function render()
    {
        return view('livewire.cart-icon');
    }
}
