<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\FilterController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProfileController;


Route::prefix('v1')->group(function () {
    
    // Auth 
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    // Catalog
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{slug}', [CategoryController::class, 'show']);
    Route::get('/ping', fn () => response()->json(['message' => 'pong']));
});


// Protected routes
Route::middleware('auth:sanctum')->group(function () {


});