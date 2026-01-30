<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;

class MyOrders extends Component
{
    public $selectedOrder = null;
    public $showModal = false;

    public function viewOrder($orderId)
    {
        $this->selectedOrder = Order::where('user_id', auth()->id())
            ->where('id', $orderId)
            ->with(['items.product', 'items.promotion'])
            ->first();

        if ($this->selectedOrder) {
            $this->showModal = true;
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedOrder = null;
    }

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
