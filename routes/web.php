<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\GoogleController;


// 🏠 HOME (puedes usar productos como inicio)
Route::get('/', [ProductController::class, 'information'])->name('home');


// 📦 PRODUCTS
Route::resource('products', ProductController::class);





// 🛒 CART (PROTEGIDO 🔐)
Route::middleware('auth')->group(function () {

    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    Route::post('/cart/checkout', [CartController::class, 'checkout']);

    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
});


// 👤 DASHBOARD (Breeze)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// 👤 PROFILE (Breeze)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/auth/google', [GoogleController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);


// 🔐 AUTH (Breeze)
require __DIR__.'/auth.php';