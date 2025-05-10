<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DialogFlowController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('category')->group(function(){
    Route::get('/',[CategoryController::class,'index']);
    Route::post('/',[CategoryController::class,'store']);
    Route::get('/{id}', [CategoryController::class, 'show']); 
    Route::put('/{id}', [CategoryController::class, 'update']); 
    Route::patch('/{id}', [CategoryController::class, 'update']); 
    Route::delete('/{id}', [CategoryController::class, 'destroy']);
});

Route::prefix('product')->group(function(){
    Route::get('/',[ProductController::class,'index']);
    Route::post('/',[ProductController::class,'store']);
    Route::get('/{id}', [ProductController::class, 'show']); 
    Route::put('/{id}', [ProductController::class, 'update']); 
    Route::patch('/{id}', [ProductController::class, 'update']); 
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});

Route::post('/dialogflow-webhook', DialogFlowController::class);
