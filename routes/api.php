<?php

use Illuminate\Support\Facades\Route;


// route login
Route::post('/login', [App\Http\Controllers\Api\Auth\LoginController::class, 'index']);

Route::post('/validate-token', [App\Http\Controllers\Api\Auth\LoginController::class, 'validateToken']);
//group route with middleware "auth"
Route::group(['middleware' => 'auth:api'], function () {
    //logout
    Route::post('/logout', [App\Http\Controllers\Api\Auth\LoginController::class, 'logout']);
});

// Route::group(['middleware' => 'auth:api'], function () {
    //dashboard
    Route::get('/dashboard', App\Http\Controllers\Api\DashboardController::class);
    Route::get('/products', [App\Http\Controllers\Api\ProductController::class, 'index']);
    Route::get('/categories', [App\Http\Controllers\Api\ProductController::class, 'categories']);
    Route::get('/products/{id}', [App\Http\Controllers\Api\ProductController::class, 'show']);
    Route::get('/transactions', [App\Http\Controllers\Api\TransactionController::class, 'index']);
    Route::post('/transactions', [App\Http\Controllers\Api\TransactionController::class, 'store']);
    Route::prefix('customers')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\CustomerController::class, 'index']); // Index route for listing customers
        Route::post('/', [App\Http\Controllers\Api\CustomerController::class, 'store']); // Store route for creating a customer
        Route::get('/{id}', [App\Http\Controllers\Api\CustomerController::class, 'show']); // Show route for retrieving a single customer
    });
// });
