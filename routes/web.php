<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EstimationController;
use App\Http\Controllers\PicPoController;
use App\Http\Controllers\UserController;
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
    return view('user.index');
});

Route::prefix('/user')->group(function () {
    Route::get('/', [UserController::class, 'index']);
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
    Route::post('/', [EstimationController::class, 'store']);
    Route::patch('/{id}', [EstimationController::class, 'update']);
    Route::delete('/{id}', [EstimationController::class, 'destroy']);
});
