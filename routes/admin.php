<?php

use App\Http\Controllers\API\Admin\AuthController;
use App\Http\Controllers\API\Admin\CategoryController;
use App\Http\Controllers\API\Admin\BrandController;
use App\Http\Controllers\API\Admin\ProductController;
use App\Http\Controllers\API\Admin\ShelfController;
use App\Http\Controllers\API\Admin\SupplierController;
use Illuminate\Support\Facades\Route;

//Route::prefix('suppliers')->group(function() {
//  Route::get('/', [SupplierController::class, 'index']);
//  Route::post('/', [SupplierController::class, 'store']);
//  Route::get('/{id}', [SupplierController::class, 'show']);
//  Route::patch('/{id}', [SupplierController::class, 'update']);
//  Route::delete('/{id}', [SupplierController::class, 'destroy']);
//});
//
//Route::prefix('categories')->group(function() {
//  Route::get('/', [CategoryController::class, 'index']);
//  Route::post('/', [CategoryController::class, 'store']);
//  Route::get('/{id}', [CategoryController::class, 'show']);
//  Route::patch('/{id}', [CategoryController::class, 'update']);
//  Route::delete('/{id}', [CategoryController::class, 'destroy']);
//});

Route::middleware('json.response')->group(function() {
  Route::prefix("auth")->group(function() {
    Route::post("/login", [AuthController::class, "login"]);
  });

  Route::apiResource("suppliers", SupplierController::class);
  Route::apiResource("categories", CategoryController::class);
  Route::apiResource("brands", BrandController::class);
  Route::apiResource("products", ProductController::class);
  Route::apiResource("shelves", ShelfController::class);
});
