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
    
    // Promotion State
    public $editingPromotionId = null;
    public $bundleItems = []; // Array of ['product_id' => int, 'name' => string, 'price' => float, 'quantity' => int] (Quantity is bundle count)
    public $discountPercent = 0;
    public $productSearch = '';
    public $searchResults = [];

    // Toast State
    public $showToast = false;
    public $toastMessage = '';

    protected $queryString = [
        'activeTab' => ['except' => 'inventory'],
        'selectedMain' => ['except' => 'Beverages'],
        'selectedSub' => ['except' => ''],
        'search' => ['except' => ''],
    ];

    public function updatedProductSearch()
    {
        if (strlen($this->productSearch) > 1) {
            $this->searchResults = Product::where('name', 'like', '%' . $this->productSearch . '%')
                ->take(5)
                ->get()
                ->toArray();
        } else {
            $this->searchResults = [];
        }
    }

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
        if ($this->selectedMain === 'Promotions') {
            $this->editPromotion($id);
            return;
        }

        $product = Product::find($id);
        if ($product) {
            $this->editingProductId = $id;
            $this->editingName = $product->name;
            $this->editingPrice = $product->price;
            $this->editingStock = $product->stock_quantity;
            $this->editingDescription = $product->description;
        }
    }
    
    public function editPromotion($id)
    {
        $promotion = Promotion::with('products')->find($id);
        if ($promotion) {
            $this->editingPromotionId = $id;
            $this->editingName = $promotion->name;
            $this->editingDescription = $promotion->description;
            $this->discountPercent = $promotion->discount_percent;
            
            // Load bundle items
            $this->bundleItems = [];
            foreach ($promotion->products as $product) {
                // We add each product as a separate item
                $this->bundleItems[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => (float)$product->price
                ];
            }
        }
    }
    
    public function addProductToBundle($productId)
    {
        $product = Product::find($productId);
        if ($product) {
            $this->bundleItems[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => (float)$product->price
            ];
            $this->productSearch = '';
            $this->searchResults = [];
        }
    }

    public function removeProductFromBundle($index)
    {
        unset($this->bundleItems[$index]);
        $this->bundleItems = array_values($this->bundleItems); // Re-index
    }

    public function getOriginalTotalProperty()
    {
        return array_reduce($this->bundleItems, function ($carry, $item) {
            return $carry + $item['price'];
        }, 0);
    }

    public function getFinalPriceProperty()
    {
        $original = $this->getOriginalTotalProperty();
        $discount = (float)$this->discountPercent;
        return max(0, $original - ($original * ($discount / 100)));
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

            $this->showToast('Product updated successfully!');
            $this->cancelEdit();
        }
    }

    public function savePromotion()
    {
        $rules = [
            'editingName' => 'required|string|max:255',
            'editingDescription' => 'nullable|string',
            'discountPercent' => 'required|integer|min:0|max:100',
        ];
        
        $this->validate($rules);
        
        // Calculate price
        $originalTotal = $this->getOriginalTotalProperty();
        $finalPrice = max(0, $originalTotal - ($originalTotal * ($this->discountPercent / 100)));

        if ($this->editingPromotionId) {
            $promotion = Promotion::find($this->editingPromotionId);
            $promotion->update([
                'name' => $this->editingName,
                'description' => $this->editingDescription,
                'price' => $finalPrice,
                'discount_percent' => $this->discountPercent,
            ]);
            
            // Sync products
            // Since pivot table has no quantity and usually unique (product_id, promotion_id), 
            // if we want multiple of the same product, we can't use standard sync without extra pivot data columns or allowing duplicates.
            // For this implementation, I will just sync the list of unique product IDs.
            // If the user adds "Latte" twice, it will only be saved once.
            $productIds = array_column($this->bundleItems, 'product_id');
            $promotion->products()->sync($productIds);
            
            $this->showToast('Promotion updated successfully!');
        } else {
            // Create
            $promotion = Promotion::create([
                'name' => $this->editingName,
                'description' => $this->editingDescription,
                'price' => $finalPrice,
                'discount_percent' => $this->discountPercent,
            ]);
            
             $productIds = array_column($this->bundleItems, 'product_id');
             $promotion->products()->attach($productIds);
             
             $this->showToast('Promotion created successfully!');
        }
        
        $this->cancelEdit();
    }
    
    public function createPromotion() {
        $this->cancelEdit(); // Reset
        $this->mode = 'create_promotion'; 
        // We handle this view state in blade. Or reuse generic create mode.
        // Actually, let's keep it simple. If SelectedMain is Promotion and we click Add, we clear state and set mode='create'.
    }

    public function deleteProduct()
    {
        $product = Product::find($this->editingProductId);
        if ($product) {
            $product->delete();
            $this->showToast('Product deleted successfully!');
            $this->cancelEdit();
        }
    }
    
    public function deletePromotion()
    {
        $promotion = Promotion::find($this->editingPromotionId);
        if ($promotion) {
            $promotion->delete();
            $this->showToast('Promotion deleted successfully!');
            $this->cancelEdit();
        }
    }
    
    public function showToast($message)
    {
        $this->toastMessage = $message;
        $this->showToast = true;
    }

    public function cancelEdit()
    {
        $this->editingProductId = null;
        $this->editingPromotionId = null;
        $this->editingName = '';
        $this->editingPrice = '';
        $this->editingStock = '';
        $this->editingDescription = '';
        $this->bundleItems = [];
        $this->discountPercent = 0;
        $this->productSearch = '';
        $this->searchResults = [];
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
