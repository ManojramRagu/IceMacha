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

    public function addToCart($productId, $type = 'product')
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userId = auth()->id();
        
        // Find or create cart
        $cart = \App\Models\Cart::firstOrCreate(
            ['UserId' => $userId],
            ['dataset' => 'legacy']
        );

        if ($type === 'bundle') {
            // Handle Bundle (Promotion)
            $cartItem = \App\Models\CartItem::where('CartId', $cart->CartId)
                ->where('PromotionId', $productId) // $productId is promotion_id here
                ->first();

            if ($cartItem) {
                $cartItem->increment('Quantity');
            } else {
                \App\Models\CartItem::create([
                    'CartId' => $cart->CartId,
                    'PromotionId' => $productId,
                    'ProductId' => null,
                    'Quantity' => 1
                ]);
            }
        } else {
            // Handle Product
            $cartItem = \App\Models\CartItem::where('CartId', $cart->CartId)
                ->where('ProductId', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->increment('Quantity');
            } else {
                \App\Models\CartItem::create([
                    'CartId' => $cart->CartId,
                    'ProductId' => $productId,
                    'PromotionId' => null,
                    'Quantity' => 1
                ]);
            }
        }

        // Dispatch event to update navbar icon
        $this->dispatch('cartUpdated');

        // Show toast
        $this->toastMessage = ($type === 'bundle' ? 'Bundle' : 'Item') . ' added to cart successfully!';
        $this->showToast = true;
    }

    public function selectProduct($productId)
    {
        $this->selectedProduct = Product::find($productId);
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
            'products' => \App\Models\Product::with('category')->get(),
            'promotions' => \App\Models\Promotion::with('products')->get() // Fetch bundles
        ])->layout('layouts.app');
    }
}