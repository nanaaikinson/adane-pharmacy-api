<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
  use ResponseTrait;

  public function index(): JsonResponse
  {
    try {
      $customerCount = Customer::count();
      $productCount = Product::count();
      $supplierCount = Supplier::count();
      $outOfStock = Product::where("quantity", 0)->count();
      $expired = Product::with(["purchaseItems" => function ($query) {
        $query->whereNotNull("expiry_date")->whereDate("expiry_date", "<", Carbon::now());
      }])
        ->where("has_expiry", 1)
        ->count();

      return $this->dataResponse([
        "customer_count" => $customerCount,
        "product_count" => $productCount,
        "supplier_count" => $supplierCount,
        "out_of_stock" => $outOfStock,
        "expired_product_count" => $expired
      ]);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}
