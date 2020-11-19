<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StockController extends Controller
{
  use ResponseTrait;

  /**
   * List stock items
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function index(Request $request): JsonResponse
  {
    try {
      $limit = $request->get("limit") ?: 20;
      $products = Product::with("supplier")
        ->with("orderItems")
        ->paginate($limit);

      // Transform data
      $data = new \stdClass();
      $data->items = $products->getCollection()->transform(function ($product) {
        $quantity = (float)$product->quantity;

        return [
          "product_id" => $product->id,
          "product_mask" => $product->mask,
          "product_name" => $product->generic_name,
          "supplier" => $product->supplier ? $product->supplier->name : NULL,
          "quantity" => $quantity,
          "product_type" => $product->type ? $product->type->name : NULL,
          "reorder_level" => $product->reorder_level,
          "status" => $quantity < 1 ? "Out of stock" : ($quantity <= $product->reorder_level ? "Needs Reorder" : "In stock"),
          "sold_quantity" => $product->orderItems->isNotEmpty() ? $product->orderItems : 0,
        ];
      });

      // Pagination Data
      $arr = $products->toArray();
      $extra = [
        "current_page" => $arr['current_page'],
        "next_page" => $arr['next_page_url'],
        "last_page" => $arr['last_page_url'],
        "total" => $arr['total'],
      ];
      $data->page_info = $extra;

      return $this->dataResponse($data);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}
