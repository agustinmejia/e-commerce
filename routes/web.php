<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ImportsController;

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
    if(setting('ecommerce.template')){
        return view('ecommerce.'.setting('ecommerce.template').'.index');
    }
    return redirect()->route('voyager.dashboard');
});

Route::get('/list/products/filter', function () {
    return view('ecommerce.'.setting('ecommerce.template').'.list');
});

Route::get('/details/{slug}', function ($slug) {
    return view('ecommerce.'.setting('ecommerce.template').'.details', compact('slug'));
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    // Purchases
    Route::resource('purchases', PurchasesController::class);
    Route::get('purchases/list/ajax', [PurchasesController::class, 'list']);

    // Products
    Route::get('products', [ProductsController::class, 'index'])->name('voyager.products.index');
    Route::get('products/list/ajax', [ProductsController::class, 'list']);

    // Customers
    Route::get('customers/list/ajax', [CustomersController::class, 'list']);
    Route::post('customers/store', [CustomersController::class, 'store']);

    // Sales
    Route::resource('sales', SalesController::class);
    Route::get('sales/list/ajax', [SalesController::class, 'list']);
    Route::post('sales/payments/store', [SalesController::class, 'payments_store'])->name('sales.payments.store');
    Route::get('sales/print/{id}', [SalesController::class, 'print'])->name('sales.print');

    // Reportes
    Route::get('reports/sales', [ReportsController::class, 'sales_index'])->name('reports.sales.index');
    Route::post('reports/sales/list', [ReportsController::class, 'sales_list'])->name('reports.sales.list');

    // Imports
    Route::get('imports', [ImportsController::class, 'index'])->name('imports.index');
    Route::post('imports/store', [ImportsController::class, 'store'])->name('imports.store');
});

// Clear cache
Route::get('/admin/clear-cache', function() {
    Artisan::call('optimize:clear');
    return redirect('/admin/profile')->with(['message' => 'Cache eliminada.', 'alert-type' => 'success']);
})->name('clear.cache');
