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
        return [
          "product_id" => $product->id,
          "product_mask" => $product->mask,
          "product_name" => $product->generic_name,
          "supplier" => $product->supplier ? $product->supplier->name : NULL,
          "quantity" => $product->quantity,
          "sold_quantity" => $product->orderItems->isNotEmpty() ? $product->orderItems : 0
        ];
      });
      // Arr
      $arr = $products->toArray();
      dd($arr);
      $extra = [
        "current_page" => $arr['current_page'],
        "next_page" => $arr['next_page_url'],
        "total" => $arr['total'],
      ];
      $data->page_info = $extra;

      return $this->dataResponse($data);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}
