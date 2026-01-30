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
            // Check Bundle Stock (All items must have stock >= requested quantity + existing bundle quantity)
            $promotion = \App\Models\Promotion::with('products')->find($productId);
            
            // Get existing quantity of this specific bundle in cart
            $existingCartItem = \App\Models\CartItem::where('CartId', $cart->CartId)
                ->where('PromotionId', $productId)
                ->first();
            $existingBundleQty = $existingCartItem ? $existingCartItem->Quantity : 0;

            foreach ($promotion->products as $product) {
                // Check if (Existing Bundles + New Request) exceeds stock
                // content: assuming 1 unit of product per bundle for now. 
                // ideally we should also check if the user has this product added individually, but for now we fix the main loop.
                if ($product->stock_quantity < ($existingBundleQty + $quantity)) {
                    $this->toastMessage = "You have {$existingBundleQty} in cart. Only {$product->stock_quantity} left of {$product->name}!";
                    $this->showToast = true;
                    return;
                }
            }

            // Handle Bundle (Promotion)
            if ($existingCartItem) {
                $existingCartItem->increment('Quantity', $quantity);
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
            
            // Get existing quantity of this product in cart
            $existingCartItem = \App\Models\CartItem::where('CartId', $cart->CartId)
                ->where('ProductId', $productId)
                ->first();
            $existingQty = $existingCartItem ? $existingCartItem->Quantity : 0;
            
            // Check if (Existing Qty + New Qty) exceeds Stock
            if ($product->stock_quantity < ($existingQty + $quantity)) {
                $availableToAdd = $product->stock_quantity - $existingQty;
                $this->toastMessage = "You already have {$existingQty} in cart. Only {$availableToAdd} more available!";
                $this->showToast = true;
                return;
            }

            // Handle Product
            if ($existingCartItem) {
                $existingCartItem->increment('Quantity', $quantity);
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