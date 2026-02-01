<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Promotion;
use App\Models\Cart;
use App\Models\CartItem;

class HomeBundles extends Component
{
    public $showToast = false;
    public $toastMessage = '';

    public function addToCart($productId, $type = 'bundle')
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userId = auth()->id();
        
        // Find or create cart
        $cart = Cart::firstOrCreate(
            ['UserId' => $userId],
            ['dataset' => 'legacy']
        );

        if ($type === 'bundle') {
            // Handle Bundle (Promotion)
            $cartItem = CartItem::where('CartId', $cart->CartId)
                ->where('PromotionId', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->increment('Quantity');
            } else {
                CartItem::create([
                    'CartId' => $cart->CartId,
                    'PromotionId' => $productId,
                    'ProductId' => null,
                    'Quantity' => 1
                ]);
            }
        } 
        // Note: Product logic omitted as this component only handles bundles, 
        // but keeping structure similar to ProductMenu for consistency.

        // Dispatch event to update navbar icon (if navbar listens to this)
        $this->dispatch('cart-updated');

        // Show toast
        $this->toastMessage = 'Bundle added to cart successfully!';
        $this->showToast = true;
    }

    public function render()
    {
        // Fetch promotions here so it's self-contained
        // Fetch promotions and check stock integrity
        $promotions = Promotion::with('products')->get()->map(function($promo) {
            $minStock = $promo->products->min('stock_quantity');
            $promo->out_of_stock = $minStock <= 0;
            return $promo;
        });
        
        return view('livewire.home-bundles', compact('promotions'));
    }
}
