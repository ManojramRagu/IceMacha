<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CartItem;

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
        })->with('product')->get();

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
                'UserId' => auth()->id(),
                'TotalAmount' => $this->total,
                'PaymentMethod' => strtoupper($this->paymentMethod),
                'DeliveryAddress' => $this->address,
                'OrderDate' => now(),
            ]);

            // Migrate Items
            foreach ($this->cartItems as $item) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id, // Assuming relationship
                    'quantity' => $item->Quantity,
                    'price_at_purchase' => $item->product->price
                ]);
            }

            // Clear Cart
            CartItem::whereIn('CartItemId', $this->cartItems->pluck('CartItemId'))->delete();
            
            return redirect()->route('order.success', ['orderId' => $order->id]);
        }
    }

    public function render()
    {
        return view('livewire.checkout-page')->layout('layouts.app');
    }
}
