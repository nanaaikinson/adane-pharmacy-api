<?php

namespace App\Http\Controllers\API\Admin;

use App\Events\UpdateProductQuantityEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequest;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
  use ResponseTrait;

  /**
   * Get all resources
   *
   * @return JsonResponse
   */
  public function index(): JsonResponse
  {
    try {
      $purchases = Purchase::all();
      return $this->dataResponse($purchases);
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  /**
   * Persist a resource and its items
   *
   * @param StorePurchaseRequest $request
   * @return JsonResponse
   */
  public function store(StorePurchaseRequest $request): JsonResponse
  {
    try {
      DB::beginTransaction();

      $validated = (object)$request->validationData();
      $purchase = Purchase::create([
        "supplier_id" => $validated->supplier,
        "purchase_date" => $validated->purchase_date,
        "invoice_number" => $validated->invoice_number,
        "description" => $request->input("description") ?: NULL,
      ]);

      if ($purchase) {
        foreach ($validated->items as $item) {
          $item = (object)$item;

          PurchaseItem::create([
            "purchase_id" => $purchase->id,
            "product_id" => $item->product,
            "expiry_date" => $item->expiry_date,
            "cost_price" => $item->cost_price,
            "selling_price" => $item->selling_price,
            "quantity" => $item->quantity,
          ]);

          event(new UpdateProductQuantityEvent($item->product, $item->quantity, "addition"));
        }

        DB::commit();
        return $this->successResponse("Purchase saved successfully");
      }

      DB::rollBack();
      return $this->errorResponse("An error occurred while saving this purchase");
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  /**
   * Get a resource
   *
   * @param string $mask
   * @return JsonResponse
   */
  public function show(string $mask): JsonResponse
  {
    try {
      $purchase = Purchase::with("purchaseItems")->where("mask", $mask)->firstOrFail();
      return $this->dataResponse($purchase);
    }
    catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }


  public function update(StorePurchaseRequest $request, string $mask): JsonResponse
  {
    try {
      $purchase = Purchase::with("purchaseItems")->where("mask", $mask)->firstOrFail();
      $purchaseOld = $purchase;
      $validated = (object)$request->validationData();

      DB::beginTransaction();
      $updated = $purchase->update([
        "supplier_id" => $validated->supplier,
        "purchase_date" => $validated->purchase_date,
        "invoice_number" => $validated->invoice_number,
        "description" => $request->input("description") ?: NULL,
      ]);

      if ($updated) {

        DB::commit();
        return $this->successResponse("Purchase updated successfully.");
      }
      DB::rollBack();
      return $this->errorResponse("An error occurred while updating this purchase.");
    }
    catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }


  public function destroy(string $mask): JsonResponse
  {

  }

  /**
   * Truncate purchase item
   *
   * @param PurchaseItem $purchaseItem
   * @return JsonResponse
   */
  public function truncateItem(PurchaseItem $purchaseItem): JsonResponse
  {
    try {
      if ($purchaseItem->delete()) {
        event(new UpdateProductQuantityEvent($purchaseItem->product_id, $purchaseItem->quantity, "subtraction"));
        return $this->successResponse("Item deleted successfully");
      }
      return $this->errorResponse("An error occurred while deleting this item");
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}
