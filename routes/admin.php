<?php

use App\Http\Controllers\API\Admin\AuthController;
use App\Http\Controllers\API\Admin\CategoryController;
use App\Http\Controllers\API\Admin\CustomerController;
use App\Http\Controllers\API\Admin\UserController;
use App\Http\Controllers\API\Admin\FileController;
use App\Http\Controllers\API\Admin\ManufacturerController;
use App\Http\Controllers\API\Admin\ProductController;
use App\Http\Controllers\API\Admin\ProductTypeController;
use App\Http\Controllers\API\Admin\PurchaseController;
use App\Http\Controllers\API\Admin\SalesController;
use App\Http\Controllers\API\Admin\ShelfController;
use App\Http\Controllers\API\Admin\StockController;
use App\Http\Controllers\API\Admin\SupplierController;
use Illuminate\Support\Facades\Route;

Route::middleware('json.response')->group(function () {
  Route::prefix("auth")->group(function () {
    Route::post("/login", [AuthController::class, "login"]);
  });

  // Customers
  Route::prefix("customers")->group(function() {
    Route::get("/", [CustomerController::class, "index"]);
    Route::post("/", [CustomerController::class, "store"]);
    Route::get("/{mask}", [CustomerController::class, "show"]);
    Route::put("/{mask}", [CustomerController::class, "update"]);
  });

  // Users
  Route::prefix("users")->group(function() {
    Route::get("/", [UserController::class, "index"]);
    Route::post("/", [UserController::class, "store"]);
    Route::get("/{mask}", [UserController::class, "show"]);
    Route::put("/{mask}", [UserController::class, "update"]);
  });

  // Orders
  Route::prefix("orders")->group(function() {
    Route::get("/", [SalesController::class, "index"]);
    Route::post("/buy", [SalesController::class, "order"]);
  });

  // Settings
  Route::get("/suppliers/products/{supplierId}", [SupplierController::class, 'products']);
  Route::apiResource("suppliers", SupplierController::class);

  Route::apiResource("categories", CategoryController::class);
  Route::apiResource("manufacturers", ManufacturerController::class);

  Route::apiResource("shelves", ShelfController::class);
  Route::apiResource("product-types", ProductTypeController::class);

  // Products
  Route::prefix("products")->group(function() {
    Route::get("/stock", [ProductController::class, 'stock']);
    Route::get("/search", [ProductController::class, 'search']);
    Route::post("/{mask}/update", [ProductController::class, 'update']);
    Route::get("/{mask}/batch", [ProductController::class, 'batch']);

    Route::get("/", [ProductController::class, "index"]);
    Route::post("/", [ProductController::class, "store"]);
    Route::get("/{mask}", [ProductController::class, "show"]);
    Route::put("/{mask}", [ProductController::class, "update"]);
  });

  // Purchases
  Route::prefix("purchases")->group(function() {
    Route::delete("/truncate-item/{id}", [PurchaseController::class, 'truncateItem']);
    Route::get("/pdf/{mask}", [PurchaseController::class, 'pdf']);

    Route::get("/", [PurchaseController::class, "index"]);
    Route::post("/", [PurchaseController::class, "store"]);
    Route::get("/{mask}", [PurchaseController::class, "show"]);
    Route::put("/{mask}", [PurchaseController::class, "update"]);
  });

  // Files
  Route::delete("/files/delete/{fileId}", [FileController::class, "destroy"]);

  // Read only
});
