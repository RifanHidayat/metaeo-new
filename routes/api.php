<?php

use App\Http\Controllers\api\BudgetProjectApiController;
use App\Http\Controllers\api\EmployeeApiController;
use App\Http\Controllers\api\ProjectApiController;
use App\Http\Controllers\api\PurchaseOrderApiController;
use App\Http\Controllers\api\SalesOrderApiController;
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

Route::prefix('/sales-orders')->group(function () {
    Route::get('/', [SalesOrderApiController::class, 'index']);
    Route::get('/{id}', [SalesOrderApiController::class, 'show']);
});

Route::prefix('/projects')->group(function () {
    Route::get('/', [ProjectApiController::class, 'index']);
      Route::get('/{id}', [ProjectApiController::class, 'show']);
      Route::get('/{id}/budgets', [ProjectApiController::class, 'budgets']);
    //Route::get('/{id}', [SalesOrderApiController::class, 'show']);
});

Route::prefix('/employees')->group(function () {
    Route::get('/{id}/projects', [EmployeeApiController::class, 'projects']);
    //Route::get('/{id}', [SalesOrderApiController::class, 'show']);
});
Route::prefix('/budgets')->group(function () {
    Route::get('/{id}', [BudgetProjectApiController::class, 'show']);
    //Route::get('/{id}', [SalesOrderApiController::class, 'show']);
});




