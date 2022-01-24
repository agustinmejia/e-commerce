<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\ProductsControllers;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CustomersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', function () {
    return redirect('admin/login');
})->name('login');

Route::get('/', function () {
    return redirect('admin');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    // Purchases
    Route::resource('purchases', PurchasesController::class);
    Route::get('purchases/list/ajax', [PurchasesController::class, 'list']);

    // Products
    Route::get('products/list/ajax', [ProductsControllers::class, 'list']);

    // Customers
    Route::get('customers/list/ajax', [CustomersController::class, 'list']);

    // Sales
    Route::resource('sales', SalesController::class);
    Route::get('sales/list/ajax', [SalesController::class, 'list']);
    Route::post('sales/payments/store', [SalesController::class, 'payments_store'])->name('sales.payments.store');
});

// Clear cache
Route::get('/admin/clear-cache', function() {
    Artisan::call('optimize:clear');
    return redirect('/admin/profile')->with(['message' => 'Cache eliminada.', 'alert-type' => 'success']);
})->name('clear.cache');
