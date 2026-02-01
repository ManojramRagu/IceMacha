<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Layout;

#[Lazy]
#[Layout('layouts.app')]
class ProductMenu extends Component
{
    public $showModal = false;
    public $selectedProduct = null;
    public $showToast = false;
    public $toastMessage = '';
    public $toastType = 'success'; // success, warning, error

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
                $this->toastType = 'error';
                $this->showToast = true;
                return;
            }

            // Cap the quantity
            $quantityToAdd = min($quantity, $availableToAdd);
            $messageType = ($quantityToAdd < $quantity) ? 'warning' : 'success';
            $message = ($quantityToAdd < $quantity) 
                ? "Added {$quantityToAdd} bundles (Stock/Limit reached)!" 
                : "Bundle added to cart successfully!";
            $this->toastType = $messageType;

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
            $product = \App\Models\Product::available()->find($productId);

            if (!$product) {
                 $this->toastMessage = "Product is no longer available.";
                 $this->toastType = 'error';
                 $this->showToast = true;
                 return;
            }
            
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
                // Since scopeAvailable filters out stock <= 0, this likely hits the policy limit
                // or race condition where it just went to 0 but was still in cache/view
                $reason = ($existingQty >= 10) ? "Order limit of 10 reached" : "Out of stock";
                $this->toastMessage = "Cannot add more. {$reason}.";
                $this->toastType = 'error';
                $this->showToast = true;
                return;
            }

            // Cap the quantity
            $quantityToAdd = min($quantity, $availableToAdd);
            $messageType = ($quantityToAdd < $quantity) ? 'warning' : 'success';
            $message = ($quantityToAdd < $quantity) 
                ? "Added {$quantityToAdd} items (Stock/Limit reached)!" 
                : "Item added to cart successfully!";
            $this->toastType = $messageType;

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

        // Dispatch event to update navbar icon
        $this->dispatch('cart-updated');

        // Update local state if the modal is open for this product
        if ($this->selectedProduct && $this->selectedProduct->id == $productId && $type == 'product') {
            $this->quantityInCart += $quantityToAdd;
        }
    }

    public $quantityInCart = 0;

    public function selectProduct($productId)
    {
        $product = Product::available()->find($productId);
        
        if (!$product) {
             $this->toastMessage = "Product is no longer available.";
             $this->toastType = 'error';
             $this->showToast = true;
             return;
        }

        $this->selectedProduct = $product;
        
        // Calculate Quantity currently in cart for this product
        $this->quantityInCart = 0;
        if (auth()->check()) {
            $cart = \App\Models\Cart::where('UserId', auth()->id())->first();
            if ($cart) {
                $item = \App\Models\CartItem::where('CartId', $cart->CartId)
                    ->where('ProductId', $productId) 
                    ->first();
                $this->quantityInCart = $item ? $item->Quantity : 0;
            }
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedProduct = null;
    }

    public function placeholder()
    {
        return view('livewire.placeholders.menu-skeleton');
    }

    public function render()
    {
        $products = \Illuminate\Support\Facades\Cache::remember('menu_categories', 60 * 60, function () {
            return \App\Models\Product::available()->with(['category', 'subCategory'])->get();
        });

        return view('livewire.product-menu', [
            'products' => $products,
            'promotions' => \App\Models\Promotion::with('products')->get() // Fetch bundles
        ]);
    }
}