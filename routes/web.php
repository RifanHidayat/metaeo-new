<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeliveryOrderController;
use App\Http\Controllers\EstimationController;
use App\Http\Controllers\FinanceAccountController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PicPoController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\SpkController;
use App\Http\Controllers\UserController;
use App\Models\DeliveryOrder;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('estimation.index');
});

Route::prefix('/user')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/create', [UserController::class, 'create']);
    Route::get('/edit/{id}', [UserController::class, 'edit']);
    Route::post('/', [UserController::class, 'store']);
    Route::patch('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

Route::prefix('/group')->group(function () {
    Route::get('/', [GroupController::class, 'index']);
    Route::get('/create', [GroupController::class, 'create']);
    Route::get('/edit/{id}', [GroupController::class, 'edit']);
    Route::post('/', [GroupController::class, 'store']);
    Route::patch('/{id}', [GroupController::class, 'update']);
    Route::delete('/{id}', [GroupController::class, 'destroy']);
});

Route::prefix('/customer')->group(function () {
    Route::get('/', [CustomerController::class, 'index']);
    Route::get('/create', [CustomerController::class, 'create']);
    Route::get('/edit/{id}', [CustomerController::class, 'edit']);
    Route::post('/', [CustomerController::class, 'store']);
    Route::patch('/{id}', [CustomerController::class, 'update']);
    Route::delete('/{id}', [CustomerController::class, 'destroy']);
});

Route::prefix('/pic-po')->group(function () {
    Route::get('/', [PicPoController::class, 'index']);
    Route::get('/create', [PicPoController::class, 'create']);
    Route::get('/edit/{id}', [PicPoController::class, 'edit']);
    Route::post('/', [PicPoController::class, 'store']);
    Route::patch('/{id}', [PicPoController::class, 'update']);
    Route::delete('/{id}', [PicPoController::class, 'destroy']);
});

Route::prefix('/estimation')->group(function () {
    Route::get('/', [EstimationController::class, 'index']);
    Route::get('/create', [EstimationController::class, 'create']);
    Route::get('/edit/{id}', [EstimationController::class, 'edit']);
    Route::get('/print/{id}', [EstimationController::class, 'print']);
    Route::post('/', [EstimationController::class, 'store']);
    Route::patch('/{id}', [EstimationController::class, 'update']);
    Route::delete('/{id}', [EstimationController::class, 'destroy']);
});

Route::prefix('/quotation')->group(function () {
    Route::get('/', [QuotationController::class, 'index']);
    Route::get('/create', [QuotationController::class, 'create']);
    Route::get('/edit/{id}', [QuotationController::class, 'edit']);
    Route::post('/', [QuotationController::class, 'store']);
    Route::patch('/{id}', [QuotationController::class, 'update']);
    Route::delete('/{id}', [QuotationController::class, 'destroy']);
});

Route::prefix('/sales-order')->group(function () {
    Route::get('/', [SalesOrderController::class, 'index']);
    Route::get('/create', [SalesOrderController::class, 'create']);
    Route::get('/edit/{id}', [SalesOrderController::class, 'edit']);
    Route::post('/', [SalesOrderController::class, 'store']);
    Route::patch('/{id}', [SalesOrderController::class, 'update']);
    Route::delete('/{id}', [SalesOrderController::class, 'destroy']);
});

Route::prefix('/spk')->group(function () {
    Route::get('/', [SpkController::class, 'index']);
    Route::get('/create', [SpkController::class, 'create']);
    Route::get('/edit/{id}', [SpkController::class, 'edit']);
    Route::post('/', [SpkController::class, 'store']);
    Route::patch('/{id}', [SpkController::class, 'update']);
    Route::delete('/{id}', [SpkController::class, 'destroy']);
});

Route::prefix('/delivery-order')->group(function () {
    Route::get('/', [DeliveryOrderController::class, 'index']);
    Route::get('/create', [DeliveryOrderController::class, 'create']);
    Route::get('/edit/{id}', [DeliveryOrderController::class, 'edit']);
    Route::post('/', [DeliveryOrderController::class, 'store']);
    Route::patch('/{id}', [DeliveryOrderController::class, 'update']);
    Route::delete('/{id}', [DeliveryOrderController::class, 'destroy']);
});

Route::prefix('/invoice')->group(function () {
    Route::get('/', [InvoiceController::class, 'index']);
    Route::get('/create', [InvoiceController::class, 'create']);
    Route::get('/edit/{id}', [InvoiceController::class, 'edit']);
    Route::post('/', [InvoiceController::class, 'store']);
    Route::patch('/{id}', [InvoiceController::class, 'update']);
    Route::delete('/{id}', [InvoiceController::class, 'destroy']);
});

Route::prefix('/finance-account')->group(function () {
    Route::get('/', [FinanceAccountController::class, 'index']);
    Route::get('/create', [FinanceAccountController::class, 'create']);
    Route::get('/edit/{id}', [FinanceAccountController::class, 'edit']);
    Route::post('/', [FinanceAccountController::class, 'store']);
    Route::patch('/{id}', [FinanceAccountController::class, 'update']);
    Route::delete('/{id}', [FinanceAccountController::class, 'destroy']);
});

Route::prefix('/datatables')->group(function () {
    Route::prefix('/estimations')->group(function () {
        Route::get('/', [EstimationController::class, 'indexData']);
    });
    Route::prefix('/quotations')->group(function () {
        Route::get('/', [QuotationController::class, 'indexData']);
        Route::get('/estimations', [QuotationController::class, 'datatablesEstimations']);
    });
    Route::prefix('/sales-orders')->group(function () {
        Route::get('/', [SalesOrderController::class, 'indexData']);
        Route::get('/quotations', [SalesOrderController::class, 'datatablesQuotations']);
    });
    Route::prefix('/spk')->group(function () {
        Route::get('/', [SpkController::class, 'indexData']);
    });
    Route::prefix('/delivery-orders')->group(function () {
        Route::get('/', [DeliveryOrderController::class, 'indexData']);
    });
    Route::prefix('/invoices')->group(function () {
        Route::get('/', [InvoiceController::class, 'indexData']);
    });
});
