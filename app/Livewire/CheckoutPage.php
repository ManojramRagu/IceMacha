<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CartItem;

class CheckoutPage extends Component
{
    public $clientSecret;
    public $total;
    public $cartItems;

    public function mount()
    {
        $this->cartItems = CartItem::whereHas('cart', function($q) {
            $q->where('UserId', auth()->id());
        })->with('product')->get();

        if ($this->cartItems->isEmpty()) {
            return redirect()->route('cart');
        }

        $this->total = $this->cartItems->sum(fn($item) => $item->product->price * $item->Quantity);

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

    public function render()
    {
        return view('livewire.checkout-page')->layout('layouts.app');
    }
}
