<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductMenu extends Component
{
    public $showModal = false;
    public $selectedProduct = null;
    public $showToast = false;
    public $toastMessage = '';

    public function addToCart($productId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userId = auth()->id();
        
        // Find or create cart
        $cart = \App\Models\Cart::firstOrCreate(
            ['UserId' => $userId],
            ['dataset' => 'legacy'] // Optional: just to handle potential strict mode if needed, but UserId is fillable
        );

        // Check if item exists
        $cartItem = \App\Models\CartItem::where('CartId', $cart->CartId)
            ->where('ProductId', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('Quantity');
        } else {
            \App\Models\CartItem::create([
                'CartId' => $cart->CartId,
                'ProductId' => $productId,
                'Quantity' => 1
            ]);
        }

        // Dispatch event to update navbar icon
        $this->dispatch('cartUpdated');

        // Show toast
        $this->toastMessage = 'Item added to cart successfully!';
        $this->showToast = true;

        // Hide toast after 3 seconds
        $this->dispatch('hide-toast'); 
    }

    public function selectProduct($productId)
    {
        $this->selectedProduct = \App\Models\Product::find($productId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedProduct = null;
    }

    public function render()
    {
        return view('livewire.product-menu', [
            'products' => \App\Models\Product::with('category')->get()
        ])->layout('layouts.app');
    }
}