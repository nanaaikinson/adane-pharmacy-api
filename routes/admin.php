<?php

use App\Http\Controllers\API\Admin\AuthController;
use App\Http\Controllers\API\Admin\CategoryController;
use App\Http\Controllers\API\Admin\CustomerController;
use App\Http\Controllers\API\Admin\DashboardController;
use App\Http\Controllers\API\Admin\ExpenseController;
use App\Http\Controllers\API\Admin\FileController;
use App\Http\Controllers\API\Admin\ManufacturerController;
use App\Http\Controllers\API\Admin\ProductController;
use App\Http\Controllers\API\Admin\ProductTypeController;
use App\Http\Controllers\API\Admin\PurchaseController;
use App\Http\Controllers\API\Admin\ReportController;
use App\Http\Controllers\API\Admin\RoleController;
use App\Http\Controllers\API\Admin\SalesController;
use App\Http\Controllers\API\Admin\ShelfController;
use App\Http\Controllers\API\Admin\SupplierController;
use App\Http\Controllers\API\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('json.response')->group(function () {
  Route::prefix("auth")->group(function () {
    Route::post("/login", [AuthController::class, "login"]);
    Route::post("/reset-password", [AuthController::class, "resetPassword"]);
    Route::post("/logout", [AuthController::class, "logout"])->middleware("auth:admin");
    Route::get("/user", [AuthController::class, "user"])->middleware("auth:admin");
  });

  Route::middleware("auth:admin")->group(function () {
    // Customers
    Route::prefix("customers")->group(function () {
      Route::delete("/delete-multiple", [CustomerController::class, "destroyMultipleUsingId"]);

      Route::get("/", [CustomerController::class, "index"])->middleware("permission:read-customer,guard:admin");
      Route::post("/", [CustomerController::class, "store"])->middleware("permission:create-customer,guard:admin");
      Route::get("/{mask}", [CustomerController::class, "show"])->middleware("permission:read-customer,guard:admin");
      Route::put("/{mask}", [CustomerController::class, "update"])->middleware("permission:update-customer,guard:admin");
      Route::delete("/{mask}", [CustomerController::class, "destroy"])->middleware("permission:delete-customer,guard:admin");
    });

    // Users
    Route::prefix("users")->group(function () {
      Route::get("/", [UserController::class, "index"])->middleware("permission:read-user,guard:admin");
      Route::post("/", [UserController::class, "store"])->middleware("permission:create-user,guard:admin");
      Route::get("/{mask}", [UserController::class, "show"])->middleware("permission:read-user,guard:admin");
      Route::put("/{mask}", [UserController::class, "update"])->middleware("permission:update-user,guard:admin");
      Route::delete("/{mask}", [UserController::class, "destroy"])->middleware("permission:delete-user,guard:admin");
    });

    // Roles
    Route::prefix("roles")->group(function () {
      Route::get("/", [RoleController::class, "index"])->middleware("permission:read-role,guard:admin");
      Route::post("/", [RoleController::class, "store"])->middleware("permission:create-role,guard:admin");
      Route::get("/{mask}", [RoleController::class, "show"])->middleware("permission:read-role,guard:admin");
      Route::put("/{mask}", [RoleController::class, "update"])->middleware("permission:update-role,guard:admin");
      Route::delete("/{mask}", [RoleController::class, "destroy"])->middleware("permission:delete-role,guard:admin");
    });

    // Orders
    Route::prefix("orders")->group(function () {
      Route::middleware("permission:point-of-sale,guard:admin")->group(function () {
        Route::post("/buy", [SalesController::class, "order"]);
        Route::get("/", [SalesController::class, "index"]);
        Route::get("/{id}", [SalesController::class, "show"]);
      });
    });

    // Settings
    Route::middleware("permission:settings,guard:admin")->group(function () {
      Route::delete("/suppliers/delete-multiple", [SupplierController::class, "destroyMultipleUsingId"]);
      Route::apiResource("suppliers", SupplierController::class);

      Route::delete("/categories/delete-multiple", [CategoryController::class, "destroyMultipleUsingId"]);
      Route::apiResource("categories", CategoryController::class);

      Route::delete("/manufacturers/delete-multiple", [ManufacturerController::class, "destroyMultipleUsingId"]);
      Route::apiResource("manufacturers", ManufacturerController::class);

      Route::delete("/shelves/delete-multiple", [ShelfController::class, "destroyMultipleUsingId"]);
      Route::apiResource("shelves", ShelfController::class);

      Route::delete("/product-types/delete-multiple", [ProductTypeController::class, "destroyMultipleUsingId"]);
      Route::apiResource("product-types", ProductTypeController::class);

      Route::delete("/expenses/delete-multiple", [ExpenseController::class, "destroyMultipleUsingId"]);
      Route::apiResource("expenses", ExpenseController::class);
    });

    // Products
    Route::prefix("products")->group(function () {
      Route::get("/stock", [ProductController::class, 'stock']);
      Route::get("/search", [ProductController::class, 'search']);
      Route::post("/{mask}/update", [ProductController::class, 'update']);
      Route::get("/{mask}/batch", [ProductController::class, 'batch']);
      Route::get("/{mask}/purchases", [ProductController::class, 'purchases']);
      Route::get("/{mask}/sales", [ProductController::class, 'sales']);

      Route::get("/", [ProductController::class, "index"]);
      Route::post("/", [ProductController::class, "store"]);
      Route::get("/{mask}", [ProductController::class, "show"]);
      Route::put("/{mask}", [ProductController::class, "update"]);
      Route::delete("/{mask}", [ProductController::class, "destroy"]);
    });

    // Purchases
    Route::prefix("purchases")->group(function () {
      Route::delete("/truncate-item/{id}", [PurchaseController::class, 'truncateItem']);
      Route::get("/pdf/{mask}", [PurchaseController::class, 'pdf']);

      Route::get("/", [PurchaseController::class, "index"]);
      Route::post("/", [PurchaseController::class, "store"]);
      Route::get("/{mask}", [PurchaseController::class, "show"]);
      Route::put("/{mask}", [PurchaseController::class, "update"]);
      Route::delete("/{mask}", [PurchaseController::class, "destroy"]);
    });

    // Files
    Route::delete("/files/delete/{fileId}", [FileController::class, "destroy"]);

    // Read Only
    Route::prefix("read-only")->group(function() {
      Route::get("suppliers/products/{supplierId}", [SupplierController::class, 'products']);

      Route::get("categories", [CategoryController::class, "index"]);
      Route::get("suppliers", [SupplierController::class, "index"]);
      Route::get("shelves", [ShelfController::class, "index"]);
      Route::get("manufacturers", [ManufacturerController::class, "index"]);
      Route::get("products", [ProductController::class, "index"]);
      Route::get("product-types", [ProductTypeController::class, "index"]);
      Route::get("customers", [CustomerController::class, "index"]);
      Route::get("roles", [RoleController::class, "index"]);
      Route::get("permissions", [RoleController::class, "permissions"]);
    });

    // Dashboard
    Route::get("/dashboard", [DashboardController::class, "index"]);
    Route::get("/month-report", [ReportController::class, "monthReport"]);
  });
});
