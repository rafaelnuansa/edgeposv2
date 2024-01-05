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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'showLoginForm'])->name('index');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);


Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::get('/select-branch', [DashboardController::class, 'selectBranch'])->name('select.branch');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('sales', [App\Http\Controllers\SaleController::class, 'index'])->name('sales.index');
    Route::post('sales', [App\Http\Controllers\SaleController::class, 'store'])->name('sales.store');
    Route::get('product_sales', [SalesController::class, 'sales_by_product'])->name('sales.product');
    Route::get('category_sales', [SalesController::class, 'sales_by_category'])->name('sales.category');

    Route::resource('products', ProductController::class)->names('products');
    Route::resource('users', UserController::class)->names('users');
    Route::get('get_categories', [CategoryController::class, 'getCategories'])->name('json.category');

    Route::resource('categories', CategoryController::class)->names('categories');
    Route::resource('customers', CustomerController::class)->names('customers');
    Route::resource('countries', CountryController::class)->names('countries');
    Route::resource('roles', RoleController::class)->names('roles');
    Route::resource('stores', App\Http\Controllers\StoreController::class)->names('stores');
    Route::resource('branches', App\Http\Controllers\BranchController::class)->names('branches');

    Route::get('reports', [App\Http\Controllers\TransactionController::class, 'index'])->name('transactions.index');
    Route::get('reports/{transaction}', [App\Http\Controllers\TransactionController::class, 'show'])->name('transactions.show');
    Route::get('toggleDarkmode', [\App\Http\Controllers\DarkModeController::class, 'toggleDarkMode'])->name('toggle_darkmode');
});
