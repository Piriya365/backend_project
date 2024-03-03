<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HistoriesController;
use App\Http\Controllers\CustomerDetailController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::middleware('auth:sanctum')->resource('products', ProductController::class);
Route::middleware('auth:sanctum')->resource('orders', OrderController::class);
Route::middleware('auth:sanctum')->get('products/more/{id}', [ProductController::class, 'showMore'])->name('products.more');
Route::middleware('auth:sanctum')->post('orders/payment', [OrderController::class, 'storePayment'])->name('orders.histories');
Route::middleware('auth:sanctum')->resource('histories', HistoriesController::class);

Route::middleware('auth:sanctum')->resource('CustomerDetail', CustomerDetailController::class);

Route::middleware('auth:sanctum')->get('customer/{id}/edit', [CustomerDetailController::class,'edit'])->name('CustomerDetail.edit');
Route::middleware('auth:sanctum')->put('customer/{id}', [CustomerDetailController::class,'update'])->name('CustomerDetail.update');
Route::middleware('auth:sanctum')->delete('customer/{id}', [CustomerDetailController::class,'destroy'])->name('CustomerDetail.destroy');