<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ProductMenu;
use App\Livewire\CartPage;

Route::get('/', function () {
    return view('home');
})->name('home');

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