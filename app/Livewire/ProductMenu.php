<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductMenu extends Component
{
    public function render()
    {
        return view('livewire.product-menu', [
            'products' => \App\Models\Product::with('category')->get()
        ])->layout('layouts.app');
    }
}