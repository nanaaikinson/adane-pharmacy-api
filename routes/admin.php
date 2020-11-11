<?php

use App\Http\Controllers\API\Admin\AuthController;
use App\Http\Controllers\API\Admin\CategoryController;
use App\Http\Controllers\API\Admin\ManufacturerController;
use App\Http\Controllers\API\Admin\ProductController;
use App\Http\Controllers\API\Admin\ProductTypeController;
use App\Http\Controllers\API\Admin\PurchaseController;
use App\Http\Controllers\API\Admin\ShelfController;
use App\Http\Controllers\API\Admin\SupplierController;
use Illuminate\Support\Facades\Route;

Route::middleware('json.response')->group(function() {
  Route::prefix("auth")->group(function() {
    Route::post("/login", [AuthController::class, "login"]);
  });

  Route::apiResource("suppliers", SupplierController::class);
  Route::apiResource("categories", CategoryController::class);
  Route::apiResource("manufacturers", ManufacturerController::class);
  Route::apiResource("products", ProductController::class);
  Route::apiResource("shelves", ShelfController::class);
  Route::apiResource("product-types", ProductTypeController::class);

  Route::delete("/purchases/truncate-item/{id}", [PurchaseController::class, 'truncateItem']);
  Route::apiResource("purchases", PurchaseController::class);
});
