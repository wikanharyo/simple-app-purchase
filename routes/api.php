<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::post('login', [AuthController::class, 'authenticate']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::group(['prefix' => '/product'], function () {
        Route::post('/', [ProductController::class, 'store']);
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/{product_id}', [ProductController::class, 'show']);
        Route::put('/', [ProductController::class, 'update']);
        Route::delete('/{product_id}', [ProductController::class, 'delete']);
    });
    Route::group(['prefix' => '/order'], function () {
        Route::post('/store', [OrderController::class, 'store']);
        Route::get('/{order_id}', [OrderController::class, 'show']);
        Route::get('/cancel/{order_id}', [OrderController::class, 'cancel']);
        Route::get('/checkout/{order_id}', [OrderController::class, 'checkout']);
    });
});
