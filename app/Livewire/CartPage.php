<?php

namespace App\Livewire;
use App\Models\CartItem;
use Livewire\Component;

class CartPage extends Component
{
// Increases the quantity of a specific item
    public function increment($itemId)
    {
        $item = CartItem::find($itemId);
        $item->increment('quantity');
    }

    // Decreases quantity but ensures it never goes below 1
    public function decrement($itemId)
    {
        $item = CartItem::find($itemId);
        if ($item->quantity > 1) {
            $item->decrement('quantity');
        }
    }

    // Refreshes Nav Bar
    public function removeItem($itemId)
    {
        CartItem::destroy($itemId);
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        // Fetch items linked to the logged-in user
        $cartItems = CartItem::whereHas('cart', function($q) {
            $q->where('user_id', auth()->id());
        })->with('product')->get();

        return view('livewire.cart-page', [
            'cartItems' => $cartItems,
            'total' => $cartItems->sum(fn($item) => $item->product->price * $item->quantity)
        ])->layout('layouts.app');
    }
}
