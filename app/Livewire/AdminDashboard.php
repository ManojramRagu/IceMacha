<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;

class AdminDashboard extends Component
{
    public $selectedMain = 'Beverages';
    public $selectedSub = '';
    public $activeTab = 'inventory';
    public $mode = 'list'; // 'list', 'create'
    public $search = '';

    // Editing State
    public $editingProductId = null;
    public $editingName = '';
    public $editingPrice = '';
    public $editingStock = '';
    public $editingDescription = '';

    protected $queryString = [
        'activeTab' => ['except' => 'inventory'],
        'selectedMain' => ['except' => 'Beverages'],
        'selectedSub' => ['except' => ''],
        'search' => ['except' => ''],
    ];

    public function selectMain($main)
    {
        $this->selectedMain = $main;
        $this->selectedSub = ''; // Reset sub when main changes
        $this->cancelEdit();
    }

    public function selectSub($sub)
    {
        $this->selectedSub = $sub;
        $this->cancelEdit();
    }

    public function setMode($mode)
    {
        $this->mode = $mode;
        $this->cancelEdit();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->cancelEdit();
    }

    public function editProduct($id)
    {
        $product = Product::find($id);
        if ($product) {
            $this->editingProductId = $id;
            $this->editingName = $product->name;
            $this->editingPrice = $product->price;
            $this->editingStock = $product->stock_quantity;
            $this->editingDescription = $product->description;
        }
    }

    public function saveProduct()
    {
        $this->validate([
            'editingName' => 'required|string|max:255',
            'editingPrice' => 'required|numeric|min:0',
            'editingStock' => 'required|integer|min:0',
            'editingDescription' => 'nullable|string',
        ]);

        $product = Product::find($this->editingProductId);
        if ($product) {
            $product->update([
                'name' => $this->editingName,
                'price' => $this->editingPrice,
                'stock_quantity' => $this->editingStock,
                'description' => $this->editingDescription,
            ]);

            // Dispatch browser notification (using simple js alert or custom event)
            $this->dispatch('product-saved', message: 'Product updated successfully!');
            $this->cancelEdit();
        }
    }

    public function deleteProduct()
    {
        $product = Product::find($this->editingProductId);
        if ($product) {
            $product->delete();
            $this->dispatch('product-saved', message: 'Product deleted successfully!');
            $this->cancelEdit();
        }
    }

    public function cancelEdit()
    {
        $this->editingProductId = null;
        $this->editingName = '';
        $this->editingPrice = '';
        $this->editingStock = '';
        $this->editingDescription = '';
    }

    public function getProductsProperty()
    {
        if ($this->selectedMain === 'Promotions') {
            $query = Promotion::query();
            if ($this->search) {
                $query->where('name', 'like', '%' . $this->search . '%');
            }
            return $query->get();
        }

        $query = Product::query();

        if ($this->selectedSub) {
            $query->whereHas('category', function ($q) {
                $q->where('name', $this->selectedSub);
            });
        } else {
            $query->whereHas('category', function ($q) {
                $q->where('parent', $this->selectedMain);
            });
        }

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        return $query->get();
    }

    public function getSubCategoriesProperty()
    {
        // Fetch categories where parent matches selectedMain
        return Category::where('parent', $this->selectedMain)->get();
    }

    public function render()
    {
        return view('livewire.admin-dashboard');
    }
}
