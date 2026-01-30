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

        // Check Bundle Stock and Limits
        if ($type === 'bundle') {
            $promotion = \App\Models\Promotion::with('products')->find($productId);
            
            // Get existing quantity
            $existingCartItem = \App\Models\CartItem::where('CartId', $cart->CartId)
                ->where('PromotionId', $productId)
                ->first();
            $existingBundleQty = $existingCartItem ? $existingCartItem->Quantity : 0;

            // Calculate Max Addable for this Bundle based on constituent products
            $maxAddableByStock = 9999;
            foreach ($promotion->products as $product) {
                 // Simple View: Stock - (Current Bundle Qty already holding this stock)
                $currentStockUsedByBundle = $existingBundleQty; 
                $remainingStock = $product->stock_quantity - $currentStockUsedByBundle;
                
                if ($remainingStock < 0) $remainingStock = 0;
                $maxAddableByStock = min($maxAddableByStock, $remainingStock);
            }

            // Apply Policy Limit (Max 10 bundles)
            $remainingPolicyLimit = max(0, 10 - $existingBundleQty);
            
            // Final Available to Add
            $availableToAdd = min($maxAddableByStock, $remainingPolicyLimit);

            if ($availableToAdd <= 0) {
                $reason = ($existingBundleQty >= 10) ? "Order limit of 10 reached" : "Insufficient stock";
                $this->toastMessage = "Cannot add more. {$reason}.";
                $this->showToast = true;
                return;
            }

            // Cap the quantity
            $quantityToAdd = min($quantity, $availableToAdd);
            $message = ($quantityToAdd < $quantity) 
                ? "Added {$quantityToAdd} bundles (Stock/Limit reached)!" 
                : "Bundle added to cart successfully!";

            // Handle Bundle Add
            if ($existingCartItem) {
                $existingCartItem->increment('Quantity', $quantityToAdd);
            } else {
                \App\Models\CartItem::create([
                    'CartId' => $cart->CartId,
                    'PromotionId' => $productId,
                    'ProductId' => null,
                    'Quantity' => $quantityToAdd
                ]);
            }
            
            $this->toastMessage = $message;
            $this->showToast = true;

        } else {
            // Check Product Stock
            $product = \App\Models\Product::find($productId);
            
            // Get existing quantity
            $existingCartItem = \App\Models\CartItem::where('CartId', $cart->CartId)
                ->where('ProductId', $productId)
                ->first();
            $existingQty = $existingCartItem ? $existingCartItem->Quantity : 0;
            
            // Calculate Limits
            $remainingStock = max(0, $product->stock_quantity - $existingQty);
            $remainingPolicyLimit = max(0, 10 - $existingQty);
            
            $availableToAdd = min($remainingStock, $remainingPolicyLimit);

            if ($availableToAdd <= 0) {
                $reason = ($existingQty >= 10) ? "Order limit of 10 reached" : "Out of stock";
                $this->toastMessage = "Cannot add more. {$reason}.";
                $this->showToast = true;
                return;
            }

            // Cap the quantity
            $quantityToAdd = min($quantity, $availableToAdd);
            $message = ($quantityToAdd < $quantity) 
                ? "Added {$quantityToAdd} items (Stock/Limit reached)!" 
                : "Item added to cart successfully!";

            // Handle Product Add
            if ($existingCartItem) {
                $existingCartItem->increment('Quantity', $quantityToAdd);
            } else {
                \App\Models\CartItem::create([
                    'CartId' => $cart->CartId,
                    'ProductId' => $productId,
                    'PromotionId' => null,
                    'Quantity' => $quantityToAdd
                ]);
            }

            $this->toastMessage = $message;
            $this->showToast = true;
        }
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