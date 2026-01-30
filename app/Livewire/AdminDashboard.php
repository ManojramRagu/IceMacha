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
    }

    public function selectSub($sub)
    {
        $this->selectedSub = $sub;
    }

    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
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
