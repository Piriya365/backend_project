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

// การจัดการสินค้า (Product)
Route::middleware('auth:sanctum')->resource('products', ProductController::class);
// การจัดการคำสั่งซื้อ (Order)
Route::middleware('auth:sanctum')->resource('orders', OrderController::class);
// แสดงรายละเอียดเพิ่มเติมของสินค้า
Route::middleware('auth:sanctum')->get('products/more/{id}', [ProductController::class, 'showMore'])->name('products.more');
// บันทึกข้อมูลการชำระเงิน
Route::middleware('auth:sanctum')->post('orders/payment', [OrderController::class, 'storePayment'])->name('orders.histories');
// การจัดการประวัติการสั่งซื้อ (Histories)
Route::middleware('auth:sanctum')->resource('histories', HistoriesController::class);
// การจัดการข้อมูลลูกค้า (Customer Detail)
Route::middleware('auth:sanctum')->resource('CustomerDetail', CustomerDetailController::class);
// แก้ไขข้อมูลลูกค้า
Route::middleware('auth:sanctum')->get('customer/{id}/edit', [CustomerDetailController::class,'edit'])->name('CustomerDetail.edit');
// บันทึกการอัปเดตข้อมูลลูกค้า
Route::middleware('auth:sanctum')->put('customer/{id}', [CustomerDetailController::class,'update'])->name('CustomerDetail.update');
// ลบข้อมูลลูกค้า
Route::middleware('auth:sanctum')->delete('customer/{id}', [CustomerDetailController::class,'destroy'])->name('CustomerDetail.destroy');