<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
Route::post('/login',[AuthController::class,'login']);
Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::post('/logout',[AuthController::class,'logout']);

    Route::get('/profile',[AuthController::class,'profile']);

    Route::group(['middleware'=>['role:admin']],function(){
        Route::prefix('product')->group(function(){
            Route::get('/',[ProductController::class,'show']);
            Route::post('/add',[ProductController::class,'add']);
            Route::post('/edit/{id_product}',[ProductController::class,'edit']);
            Route::delete('/delete/{id_prduct}',[ProductController::class,'delete']);
        });
    });

    Route::group(['middleware'=>['role:customer']],function(){
        Route::prefix('order')->group(function(){
            Route::get('/',[OrderProductController::class,'show_order']);
            Route::post('/add',[OrderProductController::class,'add_order']);
        });
    });
});


Route::post('/register',[AuthController::class,'register']);

