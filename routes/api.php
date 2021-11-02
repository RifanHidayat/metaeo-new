<?php

use App\Http\Controllers\api\PurchaseOrderApiController;
use App\Http\Controllers\api\SupplierApiController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/customers')->group(function () {
    Route::get('/{id}/pic-pos', [CustomerController::class, 'getAllPicPos']);
});

Route::prefix('/purchase-orders')->group(function () {
    Route::get('/', [PurchaseOrderApiController::class, 'getAll']);
});

Route::prefix('/suppliers')->group(function () {
    Route::get('/{id}/purchase-orders', [SupplierApiController::class, 'getAllPurchaseOrders']);
});
