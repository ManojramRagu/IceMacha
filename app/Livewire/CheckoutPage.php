<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\OrderItem;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class CheckoutPage extends Component
{
    public $clientSecret;
    public $total;
    public $cartItems;
    public $paymentMethod = 'card';

    public function mount()
    {
        $this->cartItems = CartItem::whereHas('cart', function($q) {
            $q->where('UserId', auth()->id());
        })->with(['product', 'promotion.products'])->get();

        if ($this->cartItems->isEmpty()) {
            return redirect()->route('cart');
        }

        $this->total = $this->cartItems->sum(fn($item) => $item->product->price * $item->Quantity);

        // Always setup Stripe Intent in case they switch to Card
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $intent = \Stripe\PaymentIntent::create([
            'amount' => (int) ($this->total * 100), // Amount in cents
            'currency' => 'lkr',
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);

        $this->clientSecret = $intent->client_secret;
    }

    public function placeOrder()
    {
        if ($this->paymentMethod === 'card') {
            // Logic handled by Stripe Frontend
            return;
        }

        if ($this->paymentMethod === 'cash') {
            // Create Order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $this->total,
                'payment_method' => strtoupper($this->paymentMethod),
                'status' => 'pending',
            ]);

            // Migrate Items
            // Migrate Items & Deduct Stock
            foreach ($this->cartItems as $item) {
                if ($item->PromotionId) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'promotion_id' => $item->PromotionId,
                        'quantity' => $item->Quantity,
                        'price_at_purchase' => $item->promotion->price ?? 0
                    ]);
                } else {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product->id,
                        'quantity' => $item->Quantity,
                        'price_at_purchase' => $item->product->price
                    ]);
                }
            }
            
            $this->deductStock($order);

            // Clear Cart
            CartItem::whereIn('CartItemId', $this->cartItems->pluck('CartItemId'))->delete();
            
            return redirect()->route('order.success', ['orderId' => $order->id]);
        }
    }

    protected function deductStock(Order $order)
    {
        $order->load('items.promotion.products', 'items.product');

        foreach ($order->items as $item) {
            if ($item->product_id && $item->product) {
                // Standard Item
                $item->product->decrement('stock_quantity', $item->quantity);
            } elseif ($item->promotion_id && $item->promotion) {
                // Bundle Item - Deduct for each constituent product
                foreach ($item->promotion->products as $p) {
                    $p->decrement('stock_quantity', $item->quantity); 
                    // Note: If bundle implies multiple of same product, we rely on pivot/logic.
                    // Current Admin implementation attaches unique products.
                    // $item->quantity is how many bundles bought.
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.checkout-page');
    }
}
