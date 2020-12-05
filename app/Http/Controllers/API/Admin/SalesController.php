<?php

namespace App\Http\Controllers\API\Admin;

use App\Events\UpdateProductQuantityEvent;
use App\Events\UpdatePurchaseItemQuantity;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
  use ResponseTrait;

  public function index(Request $request)
  {
    try {

    }
    catch (Exception $e) {

    }
  }

  public function order(StoreOrderRequest $request): JsonResponse
  {
    try {
      DB::beginTransaction();
      $validated = (object)$request->validationData();
      $order = Order::create([
        "user_id" => $request->user()->id,
        "customer_id" => $validated->customer_id
      ]);

      if ($order) {
        foreach ($validated->basket as $item) {
          $item = (object)$item;
          $product = Product::findOrFail($item->product_id);
          $orderItem = OrderItem::create([
            "product_id" => $product->id,
            "price" => $product->selling_price,
            "quantity" => $item->quantity,
            "purchase_item_id" => $item->purchase_item_id,
            "order_id" => $order->id,
            "discount" => $request->input("discount") ?: 0
          ]);

          if ($orderItem) {
            event(new UpdateProductQuantityEvent($product->id, $item->quantity, "subtraction"));
            event(new UpdatePurchaseItemQuantity($item->purchase_item_id, $item->quantity));
          }
        }

        DB::commit();
        return $this->successResponse("Order placed successfully");
      }
      DB::rollBack();
      return $this->errorResponse("An error occurred while placing this order");
    }
    catch (Exception $e) {
      DB::rollBack();
      return $this->errorResponse($e->getMessage());
    }
  }
}
