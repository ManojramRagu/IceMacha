<?php
#Main SAFE
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Order;
use App\Models\Promotion;
use App\Models\ContactMessage;

class AdminDashboard extends Component
{
    use WithFileUploads;

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
    
    // Create/Upload State
    public $newImage;

    // Promotion State
    public $editingPromotionId = null;
    public $bundleItems = []; // Array of ['product_id' => int, 'name' => string, 'price' => float, 'quantity' => int] (Quantity is bundle count)
    public $discountPercent = 0;
    public $productSearch = '';
    public $searchResults = [];

    // Toast State
    public $showToast = false;
    public $toastMessage = '';

    // Feedback State
    public $viewingMessage = null;

    // Confirmation Modal State
    public $confirmingDelete = false;
    public $deleteType = ''; // 'product', 'promotion', 'message'
    public $deleteId = null;

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
        $this->mode = 'list';
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


    public function storeProduct()
    {
        $this->validate([
            'editingName' => 'required|string|max:255',
            'editingPrice' => 'required|numeric|min:0',
            'editingStock' => 'required|integer|min:0',
            'editingDescription' => 'nullable|string',
            'newImage' => 'required|image|max:2048', // 2MB Max
            'selectedMain' => 'required',
            'selectedSub' => 'required_unless:selectedMain,Promotions'
        ]);

        $imagePath = null;
        if ($this->newImage) {
            // Sanitize filename
            $filename = Str::slug($this->editingName) . '.' . $this->newImage->getClientOriginalExtension();
            
            // Construct Path: products/{Main}/{Sub}/
            $path = 'products/' . $this->selectedMain . '/' . ($this->selectedSub ?? 'General');
            
            // Store file
            // Storage::disk('public')->putFileAs($path, $this->newImage, $filename);
             $this->newImage->storeAs($path, $filename, 'public'); 

            // DB Path format: storage/products/{Main}/{Sub}/{filename}
            $imagePath = 'storage/' . $path . '/' . $filename;
            
            // Note: If using standard asset('storage/...') helper, the DB usually stores 'products/...'. 
            // But user requested full access path logic. If asset() is used on this value directly, 
            // it naturally works if relative to public root. 
            // Standard Laravel: public/storage -> storage/app/public.
            // If we store 'storage/products/...', then asset('storage/products/...') would allow double storage if not careful?
            // Actually, if we store 'products/...' in public disk, it lands in storage/app/public/products/...
            // The symlink maps public/storage to storage/app/public.
            // So to access it via web, we need 'storage/products/...'.
            // If the DB stores 'storage/products/...', then `asset($product->ImagePath)` results in `http://.../storage/products/...` which is correct.
        }

        // Find SubCategory ID
        $subCategory = SubCategory::where('name', $this->selectedSub)
            ->whereHas('category', function ($q) {
                $q->where('name', $this->selectedMain);
            })->first();
        
        if (!$subCategory) {
             $this->showToast('Category Error!', 'error');
             return;
        }

        Product::create([
            'name' => $this->editingName,
            'price' => $this->editingPrice,
            'stock_quantity' => $this->editingStock,
            'description' => $this->editingDescription,
            'category_id' => $subCategory->category_id,
            'sub_category_id' => $subCategory->id,
            'image_path' => $imagePath ?? 'img/placeholder.png' // Default
        ]);

        $this->showToast('Product created successfully!');
        $this->cancelEdit();
        $this->mode = 'list';
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
            'discountPercent' => 'required|integer|min:5|max:80',
            'bundleItems' => 'required|array|min:2',
        ];
        
        $this->validate($rules, [
            'bundleItems.min' => 'A bundle must have at least 2 items.'
        ]);
        
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
            
            // Sync products manually to allow duplicates
            $promotion->products()->detach();
            foreach ($this->bundleItems as $item) {
                $promotion->products()->attach($item['product_id']);
            }
            
            $this->showToast('Promotion updated successfully!');
        } else {
            // Create
            $promotion = Promotion::create([
                'name' => $this->editingName,
                'description' => $this->editingDescription,
                'price' => $finalPrice,
                'discount_percent' => $this->discountPercent,
            ]);
            
            foreach ($this->bundleItems as $item) {
                 $promotion->products()->attach($item['product_id']);
            }
             
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

    public function confirmDelete($type, $id)
    {
        $this->confirmingDelete = true;
        $this->deleteType = $type;
        $this->deleteId = $id;
    }

    public function performDelete()
    {
        if ($this->deleteType === 'product') {
            $product = Product::find($this->deleteId);
            if ($product) {
                $product->delete();
                $this->showToast('Product deleted successfully!');
                $this->cancelEdit();
            }
        } elseif ($this->deleteType === 'promotion') {
            $promotion = Promotion::find($this->deleteId);
            if ($promotion) {
                $promotion->delete();
                $this->showToast('Promotion deleted successfully!');
                $this->cancelEdit();
            }
        } elseif ($this->deleteType === 'message') {
            ContactMessage::destroy($this->deleteId);
            $this->showToast('Message deleted successfully.');
            $this->viewingMessage = null;
        }

        $this->confirmingDelete = false;
        $this->deleteType = '';
        $this->deleteId = null;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = false;
        $this->deleteType = '';
        $this->deleteId = null;
    }

    public function deleteProduct()
    {
        // Legacy direct call wrapper or unused if switched entirely
        $this->confirmDelete('product', $this->editingProductId);
    }
    
    public function deletePromotion()
    {
        $this->confirmDelete('promotion', $this->editingPromotionId);
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
        $this->searchResults = [];
        $this->newImage = null; // Clear upload
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
            $query->whereHas('subCategory', function ($q) {
                $q->where('name', $this->selectedSub);
            });
        } else {
            $query->whereHas('category', function ($q) {
                $q->where('name', $this->selectedMain);
            });
        }

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        return $query->get();
    }

    public function getSubCategoriesProperty()
    {
        // Fetch subcategories where category name matches selectedMain
        return SubCategory::whereHas('category', function ($q) {
            $q->where('name', $this->selectedMain);
        })->get();
    }

    public function getOrdersProperty()
    {
        return Order::with('user')->latest()->take(50)->get();
    }

    public function getMessagesProperty()
    {
        return ContactMessage::latest()->get();
    }

    public function viewMessage($id)
    {
        $this->viewingMessage = ContactMessage::find($id);
        if ($this->viewingMessage) {
            // $this->viewingMessage->update(['is_read' => true]); // Legacy schema support
        }
    }

    public function closeMessage()
    {
        $this->viewingMessage = null;
    }

    public function deleteMessage($id)
    {
        ContactMessage::destroy($id);
        $this->showToast('Message deleted successfully.');
        $this->viewingMessage = null;
    }

    public function render()
    {
        return view('livewire.admin-dashboard');
    }
}
