<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
  use ResponseTrait;

  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function index(Request $request): JsonResponse
  {
    try {
      $products = Product::with("brand")
        ->with("supplier")
        ->with("shelf")
        ->with("categories")
        ->get();

      return $this->dataResponse($products);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  /**
   * Store a resource
   *
   * @param StoreProductRequest $request
   * @return JsonResponse
   */
  public function store(StoreProductRequest $request)
  {
    try {
      DB::beginTransaction();
      $validated = (object)$request->validationData();
      $product = Product::create([
        "brand_name" => $validated->brand_name,
        "generic_name" => $validated->generic_name,
        "purchased_date" => $request->purchased_date ?: NULL,
        "expiry_date" => $request->expiry_date ?: NULL,
        //"quantity" => $validated->quantity,
        "reorder_level" => $validated->reorder_level,
        "selling_price" => $validated->selling_price,
        "cost_price" => $validated->cost_price,
        "shelf_id" => $validated->shelf,
        //"supplier_id" => $validated->supplier ?: NULL,
        "brand_id" => $validated->brand ?: NULL,
        "product_type_id" => $validated->product_type ?: NULL,
        "description" => $validated->description ?: NULL,
        "side_effects" => $validated->side_effects ?: NULL,
        "barcode" => $validated->barcode ?: NULL,
        "product_number" => $validated->product_number ?: NULL,
        "discount" => $request->discount ?: NULL,
        "slug" => Str::slug($validated->generic_name)
      ]);

      if ($product) {
        // Attach categories to product
        $product->categories()->attach($validated->categories);

        if ($request->hasFile("images")) {
          $product->addMultipleMediaFromRequest($request->file("images"))
            ->each(function ($file) {
              $file->toMediaCollection("images");
            });
        }
        DB::commit();
        // TODO: Fire event for websocket
        $product = $product->with("categories")->first();
        return $this->successDataResponse($product, "Product saved successfully");
      }
      DB::rollBack();
      return $this->errorResponse("An error occurred while saving this product");
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param $mask
   * @return JsonResponse
   */
  public function show($mask): JsonResponse
  {
    try {
      $product = Product::with("manufacturer")
        ->with("supplier")
        ->with("shelf")
        ->with("categories")
        ->where("mask", $mask)
        ->firstOrFail();

      dd($product);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param StoreProductRequest $request
   * @param string $mask
   * @return JsonResponse
   */
  public function update(StoreProductRequest $request, string $mask): JsonResponse
  {
    try {
      $product = Product::where("mask", $mask)->firstOrFail();
      $media = $product->getMedia();
      $validated = (object)$request->validationData();
      DB::beginTransaction();

      $updated = $product->update([
        "brand_name" => $validated->brand_name,
        "generic_name" => $validated->generic_name,
        "purchased_date" => $validated->purchased_date,
        "expiry_date" => $validated->expiry_date,
        //"quantity" => $validated->quantity,
        "reorder_level" => $validated->reorder_level,
        "selling_price" => $validated->selling_price,
        "cost_price" => $validated->cost_price,
        "shelf_id" => $validated->shelf,
        //"supplier_id" => $validated->supplier,
        //"manufacturer_id" => $validated->manufacturer,
        "description" => $validated->description ?: NULL,
        "side_effects" => $validated->side_effects ?: NULL,
        "barcode" => $validated->barcode ?: NULL,
        "product_number" => $validated->product_number ?: NULL,
        "discount" => $validated->discount ?: NULL,
        "slug" => Str::slug($validated->generic_name)
      ]);

      if ($updated) {
        // Sync categories to product
        $product->categories()->sync($validated->categories);

        // Upload files of any
        if ($request->hasFile("images")) {
          $uploaded = $product->addMultipleMediaFromRequest($request->file("images"))
            ->each(function ($file) {
              $file->toMediaCollection("images");
            });
          dd($uploaded);
        }

        // TODO: Fire event for websocket
      }
      DB::rollBack();
      return $this->errorResponse("An error occurred while updating this product");
    }
    catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param string $mask
   * @return JsonResponse
   */
  public function destroy(string $mask): JsonResponse
  {
    //
  }
}
