<?php

namespace App\Http\Controllers\API\Admin;

use App\Events\UpdateProductQuantityEvent;
use App\Events\UpdatePurchaseItemQuantity;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Jobs\ProductSingleReorderJob;
use App\Jobs\SendEmailJob;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\PurchaseItem;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
  use ResponseTrait;

  public function index(Request $request): JsonResponse
  {
    try {
      $orders = Order::with(["items", "user", "customer"])->orderBy("id", "DESC")->get()->map(function ($order) {
        $quantity = 0;
        $totalPrice = 0;

        foreach ($order->items as $i ) {
          $totalPrice += (int)$i->quantity * $i->price;
          $quantity += (int)$i->quantity;
        }

        $agent = $order->user ? "{$order->user->first_name} {$order->user->last_name}" : "Unknown";
        $customer = $order->customer ? "{$order->customer->first_name} {$order->customer->last_name}" : "Unknown";

        return [
          "id" => $order->id,
          "quantity" => (int)$quantity,
          "total_price" => $totalPrice,
          "sales_agent" => $agent,
          "created_at" => $order->created_at,
          "customer" => $customer
        ];
      });
      return $this->dataResponse($orders);
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function show(int $id): JsonResponse
  {
    $order = Order::with(["items", "customer", "user"])->findOrFail($id);
    $products = $order->items->map(function ($i) {
      return $i->product;
    });

    $order->setAttribute("products", $products);
    return $this->dataResponse($order);
  }

  public function order(StoreOrderRequest $request): JsonResponse
  {
    try {
      DB::beginTransaction();
      $validated = (object)$request->validationData();
      $order = Order::create([
        "user_id" => $request->user()->id,
        "customer_id" => $validated->customer_id,
        "invoice_number" => $validated->invoice_number,
      ]);

      if ($order) {
        foreach ($validated->basket as $item) {
          $item = (object)$item;
          $product = Product::findOrFail($item->product_id);
          $purchaseItem = PurchaseItem::findOrFail($item->purchase_item_id);
          $orderItem = OrderItem::create([
            "product_id" => $product->id,
            "price" => (int)$item->quantity * (int)$purchaseItem->selling_price,
            "quantity" => $item->quantity,
            "purchase_item_id" => $item->purchase_item_id,
            "order_id" => $order->id,
            "discount" => $request->input("discount") ?: 0
          ]);

          if ($orderItem) {
            $order->setAttribute("customer", $order->customer);
            $order->setAttribute("user", $order->user);
            $order->setAttribute("items", $order->items);

            event(new UpdateProductQuantityEvent($product->id, $item->quantity, "subtraction"));
            event(new UpdatePurchaseItemQuantity($item->purchase_item_id, $item->quantity));
            dispatch(new ProductSingleReorderJob($product));
            // dispatch(new SendEmailJob($order, "products.sold"));
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
