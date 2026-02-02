<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        // Trigger Order Confirmation Event
        // In a real app: OrderConfirmation::dispatch($order);
        Log::info("Order Created: #{$order->id} for User ID: {$order->user_id}. triggering Order Confirmation Event.");
        
        // Dispatch the asynchronous job
        \App\Jobs\SendOrderConfirmationEmail::dispatch($order);
        
        // Dispatching a generic event or custom one if it exists
        // event(new \App\Events\OrderConfirmation($order));
    }
}
