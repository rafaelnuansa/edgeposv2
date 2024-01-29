<?php


use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'auth'], function () {

    Route::get('sales', [App\Http\Controllers\SaleController::class, 'index'])->name('sales.index');
    Route::post('sales', [App\Http\Controllers\SaleController::class, 'store'])->name('sales.store');

    Route::get('sales/add_to_cart/{productId}', [App\Http\Controllers\SaleController::class, 'addToCart'])->name('sales.add_to_cart');
    Route::patch('change-qty/{cartItemId}', [App\Http\Controllers\SaleController::class, 'change_qty'])->name('sales.change_qty');

    Route::delete('sales/cancel_item/{cartItemId}', [App\Http\Controllers\SaleController::class, 'cancel_item'])->name('sales.cancel_item');
    Route::delete('sales/cancel-cart', [App\Http\Controllers\SaleController::class, 'cancel_cart'])->name('sales.cancel_item');
    Route::post('sales/hold', [App\Http\Controllers\SaleController::class, 'hold_cart'])->name('sales.hold_cart');

    Route::get('sales/held', [App\Http\Controllers\SaleController::class, 'heldOrders'])->name('sales.held_orders');
    Route::get('sales/held/{holdId}', [App\Http\Controllers\SaleController::class, 'heldOrderItems'])->name('sales.held_order_items');
    Route::get('sales/fetch-held-orders', [App\Http\Controllers\SaleController::class, 'fetchHeldOrders'])->name('sales.fetchHeldOrders');
    Route::get('sales/charge', [App\Http\Controllers\SaleController::class, 'charge'])->name('sales.charge');
    Route::post('sales/proceed', [App\Http\Controllers\SaleController::class, 'proceed'])->name('sales.proceed');
    Route::post('sales/customer', [App\Http\Controllers\SaleController::class, 'addCustomer'])->name('sales.add_customer');

    Route::get('fetchProductsAndCategories', [App\Http\Controllers\SaleController::class, 'fetchProductsAndCategories'])->name('sales.fetchProductsAndCategories');
    Route::get('fetchCart', [App\Http\Controllers\SaleController::class, 'fetchCart'])->name('fetch.cart');


    Route::post('sales/resume-held/{holdId}', [App\Http\Controllers\SaleController::class, 'resume_held'])->name('sales.resume_held');
});
