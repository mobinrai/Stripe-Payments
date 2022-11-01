<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('product');
Route::middleware('cartMiddleware')->group(function(){
    Route::get('/checkout', [ProductController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/success', [ProductController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [ProductController::class, 'cancel'])->name('checkout.cancel');
    Route::post('/checkout/proceed', [ProductController::class, 'proceedCheckout'])->name('proceedCheckout');

    Route::get('cart', [CartController::class, 'cartList'])->name('cart.list');
    Route::post('update-cart', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('remove', [CartController::class, 'removeCart'])->name('cart.remove');
    Route::post('clear', [CartController::class, 'clearAllCart'])->name('cart.clear');
});
Route::post('cart', [CartController::class, 'addToCart'])->name('cart.store');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
