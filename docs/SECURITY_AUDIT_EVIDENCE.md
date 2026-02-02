# Security Audit Evidence: IceMacha-v2

This document presents empirical evidence of security controls implementation within the IceMacha-v2 application, mapped to specific source code locations.

## 1. Mass Assignment Vulnerability Mitigation
To prevent unauthorized users from modifying protected model attributes, the application implements strict allow-listing using Eloquent's `$fillable` property.

### Evidence: User Model
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
*(Source: `app/Models/User.php`, Lines: 28-35)*

### Evidence: Product Model
```php
    protected $fillable = [
        'name', 
        'description', 
        'price', 
        // ...
        'stock_quantity'
    ];
```
*(Source: `app/Models/Product.php`, Lines: 15-24)*

---

## 2. Role-Based Access Control (Sanctum Scopes)
The application enforces different privileges for Administrators and Standard Users by assigning specific token abilities during the login process.

### Evidence: Token Ability Logic
```php
        $abilities = $user->role === 'admin' 
            ? ['admin:all'] 
            : ['products:read', 'cart:write'];

        $token = $user->createToken($request->device_name, $abilities)->plainTextToken;
```
*(Source: `app/Http/Controllers/Api/LoginApiController.php`, Lines: 33-37)*

### Evidence: Route-Level Enforcement
```php
        Route::middleware(['auth:sanctum', 'abilities:admin:all'])->group(function () {
            Route::post('/', [ProductController::class, 'store']);
            // ...
        });
```
*(Source: `routes/api.php`, Lines: 42-46)*

---

## 3. Network Security & Throttling
### Evidence: HTTPS Enforcement
Secure Hypertext Transfer Protocol (HTTPS) is explicitly forced in production environments to ensure data integrity and confidentiality during transmission.
```php
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
```
*(Source: `app/Providers/AppServiceProvider.php`, Lines: 35-37)*

### Evidence: API Rate Limiting
To mitigate Denial-of-Service (DoS) attacks, the application strictly limits API requests to 60 per minute per user/IP.

**Service Provider Configuration:**
```php
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
```
*(Source: `app/Providers/AppServiceProvider.php`, Lines: 31-33)*

**Route Middleware Application:**
```php
Route::middleware(['throttle:60,1'])->group(function () {
    // ...
});
```
*(Source: `routes/api.php`, Line 9)*

---

## 4. Cross-Site Scripting (XSS) Protection
The application utilizes Laravel's Blade templating engine, which automatically sanitizes output using PHP's `htmlspecialchars` function when using the `{{ }}` syntax.

### Evidence: Blade Auto-Escaping
```blade
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
```
*(Source: `resources/views/layouts/app.blade.php`, Lines: 27-33)*

The usage of `{{ $header }}` ensures that any user-supplied content injected into the header variable is escaped before rendering, preventing script injection attacks.
