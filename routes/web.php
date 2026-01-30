<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ProductMenu;
use App\Livewire\CartPage;

Route::get('/', function () {
    $promotions = \App\Models\Promotion::with('products')->get();
    return view('home', compact('promotions'));
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact/store', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/menu', ProductMenu::class)->name('menu');
Route::get('/cart', CartPage::class)->name('cart');
Route::get('/checkout', App\Livewire\CheckoutPage::class)->name('checkout');
Route::get('/order-success/{orderId}', function ($orderId) {
    $order = App\Models\Order::findOrFail($orderId);
    return view('order-success', ['order' => $order]);
})->name('order.success');
Route::get('/my-orders', App\Livewire\MyOrders::class)->name('my-orders');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin',
])->group(function () {
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
});