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
        $item->increment('Quantity');
    }

    // Decreases quantity but ensures it never goes below 1
    public function decrement($itemId)
    {
        $item = CartItem::find($itemId);
        if ($item->Quantity > 1) {
            $item->decrement('Quantity');
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
            $q->where('UserId', auth()->id());
        })->with(['product', 'promotion'])->get();

        return view('livewire.cart-page', [
            'cartItems' => $cartItems,
            'total' => $cartItems->sum(function($item) {
                $price = $item->product ? $item->product->price : ($item->promotion ? $item->promotion->price : 0);
                return $price * $item->Quantity;
            })
        ])->layout('layouts.app');
    }
}
