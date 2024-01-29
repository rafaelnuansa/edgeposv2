<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('index');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::get('/select-branch/{branch_id}', [DashboardController::class, 'selectBranch'])->name('select.branch');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('transactions', [App\Http\Controllers\TransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactions/{id}', [App\Http\Controllers\TransactionController::class, 'show'])->name('transactions.show');
    Route::get('transactions/{id}/print', [App\Http\Controllers\TransactionController::class, 'print'])->name('transactions.print');
    Route::resource('products', ProductController::class)->names('products');
    Route::resource('users', UserController::class)->names('users');
    Route::get('get_categories', [CategoryController::class, 'getCategories'])->name('json.category');

    Route::resource('categories', CategoryController::class)->names('categories');
    Route::resource('customers', CustomerController::class)->names('customers');
    Route::resource('countries', CountryController::class)->names('countries');
    Route::resource('roles', App\Http\Controllers\RoleController::class)->names('roles');
    Route::resource('stores', App\Http\Controllers\StoreController::class)->names('stores');
    Route::resource('branches', App\Http\Controllers\BranchController::class)->names('branches');
    Route::resource('printers', App\Http\Controllers\PrinterController::class)->names('printers');

    Route::get('reports', [App\Http\Controllers\TransactionController::class, 'index'])->name('transactions.index');
    Route::get('reports/{transaction}', [App\Http\Controllers\TransactionController::class, 'show'])->name('transactions.show');
    Route::get('toggleDarkmode', [\App\Http\Controllers\DarkModeController::class, 'toggleDarkMode'])->name('toggle_darkmode');
    Route::get('profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
});



require __DIR__ . '/sales.php';
