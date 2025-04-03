<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

/*Route::view('/', 'dashboard')*/
/*    ->middleware(['auth', 'verified'])*/
/*    ->name('dashboard');*/

Route::get('/', [ProductController::class, 'showDashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'showAdminDashboard'])->name('admin');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::delete('/admin/products/{product}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');
    Route::get('/admin/products/create', [AdminController::class, 'createProductForm'])->name('admin.products.create');
    Route::post('/admin/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::patch('/admin/products/{product}/stock', [AdminController::class, 'updateStock'])->name('admin.products.stock.update');
    Route::get('/admin/orders/{order}', [AdminController::class, 'showOrder'])->name('admin.orders.show');
    Route::patch('/admin/orders/{order}', [AdminController::class, 'updateOrder'])->name('admin.orders.update');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware('auth')->group(function () {
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    
    // Checkout process routes
    Route::get('/checkout/shipping', [CheckoutController::class, 'shipping'])->name('checkout.shipping');
    Route::post('/checkout/shipping', [CheckoutController::class, 'processShipping'])->name('checkout.shipping.process');
    Route::get('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/checkout/payment', [CheckoutController::class, 'processPayment'])->name('checkout.payment.process');
    Route::get('/checkout/review', [CheckoutController::class, 'review'])->name('checkout.review');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place-order');
    Route::get('/checkout/confirmation/{order}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');
});

Route::get('/products', [ProductController::class, 'showProducts'])->name('products');

Route::get('cart', [CartController::class, 'cartList'])->name('cart.list');
Route::post('cart', [CartController::class, 'addToCart'])->name('cart.store');
Route::post('update-cart', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('remove', [CartController::class, 'removeCart'])->name('cart.remove');
Route::post('clear', [CartController::class, 'clearAllCart'])->name('cart.clear');

require __DIR__.'/auth.php';
