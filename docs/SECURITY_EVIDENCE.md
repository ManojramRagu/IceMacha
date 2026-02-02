# Security Implementation Evidence

## 1. Sanctum Token Abilities (Access Control)
Granular access control logic ensuring strict role-based scopes.

**File:** `app/Http/Controllers/Api/LoginApiController.php`
```php
        $abilities = $user->role === 'admin' 
            ? ['admin:all'] 
            : ['products:read', 'cart:write'];

        $token = $user->createToken($request->device_name, $abilities)->plainTextToken;
```

**File:** `routes/api.php`
```php
        // Protected (Admin only for write operations)
        Route::middleware(['auth:sanctum', 'abilities:admin:all'])->group(function () {
            Route::post('/', [ProductController::class, 'store']);
            Route::put('/{id}', [ProductController::class, 'update']);
            Route::delete('/{id}', [ProductController::class, 'destroy']);
        });
```

## 2. Mass Assignment Protection (Data Layer)
Strict allow-listing of attributes in Eloquent models.

**File:** `app/Models/User.php`
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

## 3. HTTPS Enforcement (Network Layer)
Forcing secure connections in production environments.

**File:** `app/Providers/AppServiceProvider.php`
```php
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
```

## 4. API Throttling (Rate Limiting)
Protecting API endpoints from abuse.

**File:** `app/Providers/AppServiceProvider.php`
```php
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
```

**File:** `routes/api.php`
```php
Route::middleware(['throttle:60,1'])->group(function () {
    // Auth Routes
    Route::post('/login', [LoginApiController::class, 'login']);
    // ...
});
```

## 5. Performance & Scalability (Caching)
Implementation of Server-Side Caching to reduce database load.

**File:** `app/Http/Controllers/Api/v1/ProductApiController.php`
```php
    public function index()
    {
        // Cache the paginated results for 60 seconds
        $page = request('page', 1);
        $products = Cache::remember('api_products_page_' . $page, 60, function () {
            return Product::paginate(10);
        });

        return ProductResource::collection($products);
    }
```

## 6. Data Proficiency (Complex Aggregation)
Demonstrating advanced Eloquent usage to derive insights (Top Selling/Trending Products).

**File:** `app/Http/Controllers/Api/v1/ProductApiController.php`
```php
    public function trending()
    {
        $products = Product::orderBy('stock_quantity', 'desc')
            ->take(5)
            ->get();

        return ProductResource::collection($products);
    }
```

## 7. Asynchronous Processing (Job Queues)
Offloading heavy tasks (email dispatch) to a background queue for optimal performance.

**File:** `app/Jobs/SendOrderConfirmationEmail.php`
```php
class SendOrderConfirmationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        // Email sending logic...
        Log::info("Processing Order Confirmation for Order ID: {$this->order->id}");
    }
}
```

**File:** `app/Livewire/CheckoutPage.php`
```php
                    // Dispatch Job for Async Email
                    \App\Jobs\SendOrderConfirmationEmail::dispatch($order);
```
