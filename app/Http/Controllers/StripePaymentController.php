<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Cart;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripePaymentController extends Controller
{
    public function success(Request $request)
    {
        $paymentIntentId = $request->query('payment_intent');
        
        if (!$paymentIntentId) {
            return redirect()->route('cart')->with('error', 'Invalid payment attempt.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $intent = PaymentIntent::retrieve($paymentIntentId);

            if ($intent->status === 'succeeded') {
                return $this->processOrder($intent);
            } else {
                 return redirect()->route('checkout')->with('error', 'Payment failed or was cancelled.');
            }

        } catch (\Exception $e) {
            return redirect()->route('checkout')->with('error', 'Error verifying payment: ' . $e->getMessage());
        }
    }

    protected function processOrder($intent)
    {
        $user = auth()->user();
        
        if (!$user) {
             return redirect()->route('login');
        }

        // Check if order already exists for this intent to prevent duplicates
        // (Optional but good practice if you stored intent ID in order, skipping for now as per simple requirements)
        
        // Retrieve Cart
        $cartItems = CartItem::whereHas('cart', function($q) use ($user) {
            $q->where('UserId', $user->id);
        })->with(['product', 'promotion.products'])->get();

        if ($cartItems->isEmpty()) {
            // Might have already been processed
            return redirect()->route('dashboard')->with('success', 'Order processed.');
        }

        $total = $cartItems->sum(function($item) {
            $price = $item->product ? $item->product->getRawOriginal('price') : ($item->promotion ? $item->promotion->price : 0);
            return $price * $item->Quantity;
        });

        // Create Order
        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $total, // Could also use $intent->amount / 100
            'payment_method' => 'CARD',
            'status' => 'paid', // Mark as paid since Stripe confirmed it
        ]);

        // Migrate Items
        foreach ($cartItems as $item) {
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
                    'price_at_purchase' => $item->product->getRawOriginal('price')
                ]);
            }
        }

        // Deduct Stock
        $this->deductStock($order);

        // Clear Cart
        CartItem::whereIn('CartItemId', $cartItems->pluck('CartItemId'))->delete();

        return redirect()->route('order.success', ['orderId' => $order->id]);
    }

    protected function deductStock(Order $order)
    {
        $order->load('items.promotion.products', 'items.product');

        foreach ($order->items as $item) {
            if ($item->product_id && $item->product) {
                // Standard Item
                $item->product->decrement('stock_quantity', $item->quantity);
            } elseif ($item->promotion_id && $item->promotion) {
                // Bundle Item
                foreach ($item->promotion->products as $p) {
                    $p->decrement('stock_quantity', $item->quantity);
                }
            }
        }
    }
}
