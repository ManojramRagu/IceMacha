<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;

class MyOrders extends Component
{
    public function render()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('livewire.my-orders', [
            'orders' => $orders
        ])->layout('layouts.app');
    }
}
