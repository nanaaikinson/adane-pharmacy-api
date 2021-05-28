<?php

namespace App\Http\Controllers\API\Admin;

use App\Events\UpdateProductDetailEvent;
use App\Events\UpdateProductQuantityEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequest;
use App\Jobs\PurchaseUpdateJob;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Knp\Snappy\Pdf;

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
      $purchases = Purchase::with("supplier")->with("items")->get();
      return $this->dataResponse($purchases);
    } catch (Exception $e) {
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
        "batch_number" => gmdate("YmdGis")
      ]);

      if ($purchase) {
        foreach ($validated->items as $item) {
          $item = (object)$item;

          PurchaseItem::create([
            "purchase_id" => $purchase->id,
            "product_id" => $item->product_id,
            "expiry_date" => $item->has_expiry ? $item->expiry_date : NULL,
            "cost_price" => $item->cost_price,
            "selling_price" => $item->selling_price,
            "quantity" => $item->quantity,
          ]);

          // Update product quantity
          event(new UpdateProductQuantityEvent($item->product_id, $item->quantity, "addition"));

          // Update product detail
          /*if ($item->is_selling_price) {
            event(new UpdateProductDetailEvent($item->product_id, $item->selling_price));
          }*/
        }

        DB::commit();
        return $this->successResponse("Purchase saved successfully");
      }

      DB::rollBack();
      return $this->errorResponse("An error occurred while saving this purchase");
    } catch (Exception $e) {
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
      $purchase = Purchase::with("products")
        ->with("supplier")
        ->where("mask", $mask)->firstOrFail();
      return $this->dataResponse($purchase);
    } catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  /**
   * Get a resource
   *
   * @param string $mask
   */
  public function pdf(string $mask)
  {
    try {
      $purchase = Purchase::with("products")
        ->with("supplier")
        ->where("mask", $mask)
        ->firstOrFail();

      $filename = "purchase-".time().".pdf";
      $pdf = \PDF::loadView("pdf.purchase-detail", compact("purchase"));
      $pdf->setPaper('a4')->setOrientation('landscape')->setOption('margin-bottom', 0);
      $pdf->save(storage_path("app/public/") . $filename);

      $file = Storage::disk("public")->get($filename);

      if ($file) {
        $base64 = "data:application/pdf;base64," . base64_encode($file);
        Storage::disk("public")->delete($filename);
        return $this->dataResponse(['url' => $base64, 'filename' => $filename]);
      }
      return $this->errorResponse('An error occurred while generating the PDF version of this purchase');
    } catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }


  public function update(StorePurchaseRequest $request, string $mask): JsonResponse
  {
    try {
      return $this->successResponse("Updated testing");

      $purchase = Purchase::with("items")->where("mask", $mask)->firstOrFail();
      $purchaseItems = $purchase->items;
      $validated = (object)$request->validationData();

      DB::beginTransaction();
      $updatedPurchase = $purchase->update([
        "supplier_id" => $validated->supplier,
        "purchase_date" => $validated->purchase_date,
        "invoice_number" => $validated->invoice_number,
        "description" => $request->input("description") ?: NULL,
      ]);

      if ($updatedPurchase) {
        dispatch(new PurchaseUpdateJob($purchaseItems, $purchase, $validated));

        DB::commit();
        return $this->successResponse("Purchase update will be queued for processing.");
      } else {
        DB::rollBack();
        return $this->errorResponse("An error occurred while updating this purchase.");
      }
    } catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }


  public function destroy(string $mask): JsonResponse
  {
    DB::beginTransaction();
    try {
      $purchase = Purchase::with("items")->where("mask", $mask)->firstOrFail();
      if ($purchase->delete()) {
        foreach ($purchase->items as $item) {
          $item->delete();
        }

        DB::commit();
        return $this->successResponse("Purchase deleted successfully");
      }
      DB::rollBack();
      return $this->errorResponse("An error occurred while deleting this purchase");
    }
    catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    }
    catch (Exception $e) {
      DB::rollBack();
      return $this->errorResponse($e->getMessage());
    }
  }

  /**
   * Truncate purchase item
   *
   * @param int $id
   * @return JsonResponse
   */
  public function truncateItem(int $id): JsonResponse
  {
    try {
      $purchaseItem = PurchaseItem::findOrFail($id);
      if ($purchaseItem->delete()) {
        event(new UpdateProductQuantityEvent($purchaseItem->product_id, $purchaseItem->quantity, "subtraction"));
        return $this->successResponse("Item deleted successfully");
      }
      return $this->errorResponse("An error occurred while deleting this item");
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}
