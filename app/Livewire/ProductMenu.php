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

    public function addToCart($productId, $type = 'product', $quantity = 1)
    {
        $quantity = max(1, intval($quantity)); // Ensure positive integer

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
            // Check Bundle Stock (All items must have stock >= requested quantity)
            $promotion = \App\Models\Promotion::with('products')->find($productId);
            
            foreach ($promotion->products as $product) {
                if ($product->stock_quantity < $quantity) {
                    $this->toastMessage = "Only {$product->stock_quantity} left of {$product->name} (in bundle)!";
                    $this->showToast = true;
                    return;
                }
            }

            // Handle Bundle (Promotion)
            $cartItem = \App\Models\CartItem::where('CartId', $cart->CartId)
                ->where('PromotionId', $productId) // $productId is promotion_id here
                ->first();

            if ($cartItem) {
                $cartItem->increment('Quantity', $quantity);
            } else {
                \App\Models\CartItem::create([
                    'CartId' => $cart->CartId,
                    'PromotionId' => $productId,
                    'ProductId' => null,
                    'Quantity' => $quantity
                ]);
            }
        } else {
            // Check Product Stock
            $product = \App\Models\Product::find($productId);
            
            if ($product->stock_quantity < $quantity) {
                $this->toastMessage = "Only {$product->stock_quantity} remaining in stock!";
                $this->showToast = true;
                return;
            }

            // Handle Product
            $cartItem = \App\Models\CartItem::where('CartId', $cart->CartId)
                ->where('ProductId', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->increment('Quantity', $quantity);
            } else {
                \App\Models\CartItem::create([
                    'CartId' => $cart->CartId,
                    'ProductId' => $productId,
                    'PromotionId' => null,
                    'Quantity' => $quantity
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