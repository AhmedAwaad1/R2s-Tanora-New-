<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\UserAuthController;
use App\Http\Controllers\Api\User\Product\CategoryController;
use App\Http\Controllers\Api\User\Product\ProductController;
use App\Http\Controllers\Api\User\Product\OptionController;
use App\Http\Controllers\Api\User\Order\CartController;
use App\Http\Controllers\Api\User\Order\OrderController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/register', [UserAuthController::class, 'register']);
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/verification', [UserAuthController::class, 'verifyUser']);
    Route::post('/logout', [UserAuthController::class, 'logout']);
    Route::post('/deactivation', [UserAuthController::class, 'deactivate']);
});

Route::group([
    'prefix' => 'categories',
], function () {
    Route::get('/', [CategoryController::class, 'index']);
});

Route::group([
    'prefix' => 'products'
], function () {
    Route::get('/', [ProductController::class, 'index']);
});

Route::group([
    'prefix' => 'options'
], function () {
    Route::get('/', [OptionController::class, 'index']);
});

Route::group([
    'prefix' => 'carts'
],function ()
{
    Route::post('/create', [CartController::class, 'create']);
    Route::put('/{id}', [CartController::class, 'update']);
    Route::delete('/{id}', [CartController::class, 'delete']);
    Route::get('/', [CartController::class, 'index']);

});

Route::group([
    'prefix' => 'orders',
//    'middleware' => ['CheckRole']

], function ()
{
    Route::post('/', [OrderController::class, 'create']);
    Route::get('/{id}', [OrderController::class, 'get']);


});
