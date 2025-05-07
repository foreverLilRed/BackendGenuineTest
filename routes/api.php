<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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
    Route::post('/',[ProductController::class,'store']);
});
