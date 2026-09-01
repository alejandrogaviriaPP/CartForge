<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'information'])->name('home');
Route::get('/products/{product}/reviews', [ProductController::class, 'reviews'])->name('products.reviews');
Route::resource('products', ProductController::class)->only(['index', 'show']);
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');
Route::middleware('auth')->group(function () {

    Route::post('/products/{product}/rate', [ProductController::class, 'rate'])->name('products.rate');

    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    Route::post('/cart/checkout', [CartController::class, 'checkout']);

    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/auth/google', [GoogleController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

Route::post('/webhooks/wompi', [WebhookController::class, 'wompi'])->name('webhooks.wompi');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::patch('/products/{product}/stock', [AdminProductController::class, 'updateStock'])->name('products.stock');
    Route::resource('products', AdminProductController::class)->except('show');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
});

require __DIR__ . '/auth.php';
