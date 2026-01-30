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
        
        // Check if it's a product or promotion
        if ($item->product) {
            $stock = $item->product->stock_quantity;
            
            // Check if we can increase (stock available)
            if ($item->Quantity < $stock) {
                $item->increment('Quantity');
                $this->dispatch('cartUpdated');
            } else {
                // Send toast notification when stock limit reached
                $this->dispatch('toast', 
                    type: 'warning', 
                    message: 'Cannot add more. Only ' . $stock . ' in stock!'
                );
            }
        } else {
            // For promotions/bundles, increment without stock check (or add bundle logic if needed)
            $item->increment('Quantity');
            $this->dispatch('cartUpdated');
        }
    }

    // Decreases quantity but ensures it never goes below 1
    public function decrement($itemId)
    {
        $item = CartItem::find($itemId);
        if ($item->Quantity > 1) {
            $item->decrement('Quantity');
            $this->dispatch('cartUpdated');
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
