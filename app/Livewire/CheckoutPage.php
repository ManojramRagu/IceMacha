<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\OrderItem;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class CheckoutPage extends Component
{
    public $clientSecret;
    public $total;
    public $cartItems;
    public $paymentMethod = 'card';
    public $showToast = false;
    public $toastMessage = '';
    public $toastType = 'success';
    protected $orderId;

    public function mount()
    {
        $this->cartItems = CartItem::whereHas('cart', function($q) {
            $q->where('UserId', auth()->id());
        })->with(['product', 'promotion.products'])->get();

        if ($this->cartItems->isEmpty()) {
            return redirect()->route('cart');
        }

        $this->total = $this->cartItems->sum(function($item) {
            $price = $item->product ? $item->product->getRawOriginal('price') : ($item->promotion ? $item->promotion->price : 0);
            return $price * $item->Quantity;
        });

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
            try {
                DB::transaction(function() {
                    // Create Order
                    $order = Order::create([
                        'user_id' => auth()->id(),
                        'total_amount' => $this->total,
                        'payment_method' => strtoupper($this->paymentMethod),
                        'status' => 'pending',
                    ]);

                    // Migrate Items
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
                                'price_at_purchase' => $item->product->getRawOriginal('price')
                            ]);
                        }
                    }
                    
                    // Deduct Stock with Pessimistic Locking
                    $this->deductStock($order);

                    // Clear Cart
                    CartItem::whereIn('CartItemId', $this->cartItems->pluck('CartItemId'))->delete();
                    
                    $this->orderId = $order->id; // Temporary store for redirect

                    // Dispatch Job for Async Email
                    \App\Jobs\SendOrderConfirmationEmail::dispatch($order);
                });
            } catch (\Exception $e) {
                $this->toastMessage = $e->getMessage();
                $this->toastType = 'error';
                $this->showToast = true;
                return;
            }

            if (isset($this->orderId)) {
                return redirect()->route('order.success', ['orderId' => $this->orderId]);
            }
        }
    }

    protected function deductStock(Order $order)
    {
        foreach ($order->items as $item) {
            if ($item->product_id) {
                // Pessimistic Lock for standard product
                $product = Product::lockForUpdate()->find($item->product_id);
                if (!$product || $product->stock_quantity < $item->quantity) {
                    throw new \Exception("Insufficient stock for " . ($product->name ?? 'Product'));
                }
                $product->decrement('stock_quantity', $item->quantity);
            } elseif ($item->promotion_id) {
                // Bundle Item - Lock each constituent product
                $promotion = Promotion::with('products')->find($item->promotion_id);
                foreach ($promotion->products as $p) {
                    $product = Product::lockForUpdate()->find($p->id);
                    if (!$product || $product->stock_quantity < $item->quantity) {
                        throw new \Exception("Insufficient stock for {$product->name} in '{$promotion->name}' bundle.");
                    }
                    $product->decrement('stock_quantity', $item->quantity); 
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.checkout-page');
    }
}
