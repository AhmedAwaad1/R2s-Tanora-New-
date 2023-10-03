<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CustomAuthController;
use App\Http\Controllers\Admin\Product\CategoryController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\Product\OptionController;
use App\Http\Controllers\Admin\Product\OrderController;

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


Route::get('/login', [CustomAuthController::class, 'login'])->name('login');
Route::post('/login-action', [CustomAuthController::class, 'loginAdmin'])->name('login-action');

Route::group([
    'middleware' => ['auth', 'CheckRole']
], function () {
    Route::get('logout', [CustomAuthController::class, 'Logout']);
    Route::get('home', [CustomAuthController::class, 'home']);

    Route::group([
        'prefix' => 'admin'
    ], function () {
        Route::group([
            'prefix' => 'categories'
        ], function () {
            Route::get('/', [CategoryController::class, 'index']);
            Route::get('/create', [CategoryController::class, 'create']);
            Route::post('/', [CategoryController::class, 'store']);
            Route::get('/edit/{id}', [CategoryController::class, 'edit']);
            Route::put('/{id}', [CategoryController::class, 'update']);
            Route::delete('/{id}', [CategoryController::class, 'delete']);
        });

        Route::group([
            'prefix' => 'products'
        ], function () {
            Route::get('/', [ProductController::class, 'index']);
            Route::get('/create', [ProductController::class, 'create']);
            Route::post('/', [ProductController::class, 'store']);
            Route::get('/edit/{id}', [ProductController::class, 'edit']);
            Route::put('/{id}', [ProductController::class, 'update']);
            Route::delete('/{id}', [ProductController::class, 'delete']);

        });

        Route::group([
            'prefix' => 'users'
        ], function () {
            Route::get('/', [UserController::class, 'index']);
            Route::get('/create', [UserController::class, 'create']);
            Route::post('/', [UserController::class, 'store']);
            Route::get('/edit/{id}', [UserController::class, 'edit']);
            Route::put('/{id}', [UserController::class, 'update']);
            Route::delete('/{id}', [UserController::class, 'delete']);
        });

        Route::group([
            'prefix' => 'options'
        ], function () {
            Route::get('/', [OptionController::class, 'index']);
            Route::get('/create', [OptionController::class, 'create']);
            Route::post('/', [OptionController::class, 'store']);
            Route::get('/edit/{id}', [OptionController::class, 'edit']);
            Route::put('/{id}', [OptionController::class, 'update']);
            Route::delete('/{id}', [OptionController::class, 'delete']);
        });

        Route::group([
            'prefix' => 'orders'
        ], function () {
            Route::get('/', [OrderController::class, 'index']);
            Route::get('/edit/{id}', [OrderController::class, 'edit']);
            Route::put('/{id}', [OrderController::class, 'update']);
            Route::delete('/{id}', [OrderController::class, 'delete']);
        });

    });

});

