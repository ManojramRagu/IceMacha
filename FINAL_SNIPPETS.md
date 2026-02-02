# Final Security & Performance Snippets

## 1. Data Layer Evidence

### Mass Assignment Protection (User Model)
**File Path:** `app/Models/User.php`  
**Line:** 28
```php
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
    ];
```

### Mass Assignment Protection (Product Model)
**File Path:** `app/Models/Product.php`  
**Line:** 15
```php
    protected $fillable = [
        'name', 
        'description', 
        'price', 
        'image_path', 
        'category_id', 
        'sub_category_id', 
        'status', 
        'stock_quantity'
    ];
```

### SQL Injection Mitigation (Eloquent Parameter Binding)
**File Path:** `app/Http/Controllers/Api/v1/ProductApiController.php`  
**Line:** 56
```php
        // Eloquent automatically binds $id, preventing SQL injection
        $product = Product::findOrFail($id);
```

### Cryptographic Hashing (Password Hashing)
**File Path:** `app/Models/User.php`  
**Line:** 67
```php
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'phone' => 'encrypted',
            'address' => 'encrypted',
        ];
```

**File Path:** `app/Http/Controllers/Api/LoginApiController.php`  
**Line:** 27
```php
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
```

---

## 2. Application Layer Evidence

### Role-Based Access Control (Sanctum Scopes)
**File Path:** `app/Http/Controllers/Api/LoginApiController.php`  
**Line:** 33
```php
        $abilities = $user->role === 'admin' 
            ? ['admin:all'] 
            : ['products:read', 'cart:write'];

        $token = $user->createToken($request->device_name, $abilities)->plainTextToken;
```

### Admin 2FA Requirement Check
**File Path:** `app/Http/Middleware/EnsureUserIsAdmin.php`  
**Line:** 14
```php
            if (!$request->user()->two_factor_secret) {
                return redirect()->route('profile.2fa')->with('flash_error', 'Security Enforcement: Please enable Two-Factor Authentication to access administrative features.');
            }
```

### IDOR Prevention (Ownership Verification)
**File Path:** `app/Livewire/CheckoutPage.php`  
**Line:** 28
```php
        $this->cartItems = CartItem::whereHas('cart', function($q) {
            $q->where('UserId', auth()->id());
        })->with(['product', 'promotion.products'])->get();
```

### XSS Protection (Blade Auto-Escaping)
**File Path:** `resources/views/layouts/app.blade.php`  
**Line:** 30
```blade
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
```

### CSRF Protection (Directives & Meta Tags)
**File Path:** `resources/views/auth/login.blade.php`  
**Line:** 22
```blade
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
```

**File Path:** `resources/views/layouts/app.blade.php`  
**Line:** 6
```blade
        <meta name="csrf-token" content="{{ csrf_token() }}">
```

---

## 3. Infrastructure & Resilience Evidence

### API Rate Limiting Definition
**File Path:** `app/Providers/AppServiceProvider.php`  
**Line:** 31
```php
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
```

### API Throttling Application
**File Path:** `routes/api.php`  
**Line:** 9
```php
Route::middleware(['throttle:60,1'])->group(function () {
```

### HTTPS Enforcement
**File Path:** `app/Providers/AppServiceProvider.php`  
**Line:** 35
```php
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
```

### Server-Side Caching Implementation
**File Path:** `app/Http/Controllers/Api/v1/ProductApiController.php`  
**Line:** 19
```php
        $products = Cache::remember('api_products_page_' . $page, 60, function () {
            return Product::paginate(10);
        });
```

### Environment Isolation (.env Usage)
**File Path:** `.env.example`  
**Key References:**
```properties
APP_KEY=
DB_PASSWORD=
AWS_SECRET_ACCESS_KEY=
STRIPE_SECRET=
```
