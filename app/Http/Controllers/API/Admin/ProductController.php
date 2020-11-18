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
      $products = Product::with("manufacturer")
        ->with("supplier")
        ->with("shelf")
        ->with("categories")
        ->with("media")
        ->orderBy("id", "DESC")
        ->get()->map(function ($product) {

          $images = $product->media->isNotEmpty() ? $product->media[0]->getFullUrl() : NULL;

          return [
            "id" => (int)$product->id,
            "mask" => $product->mask,
            "brand_name" => $product->brand_name,
            "generic_name" => $product->generic_name,
            "quantity" => $product->quantity,
            "has_expiry" => $product->has_expiry,
            "reorder_level" => $product->reorder_level,
            "supplier" => $product->supplier ? $product->supplier->name : NULL,
            "manufacturer" => $product->manufacturer ? $product->manufacturer->name : NULL,
            "shelf" => $product->shelf ? $product->shelf->name : NULL,
            "images" => $images
          ];
        });

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

  public function store(StoreProductRequest $request): JsonResponse
  {
    try {
      DB::beginTransaction();
      $validated = (object)$request->validationData();
      $product = Product::create([
        "brand_name" => $validated->brand_name,
        "generic_name" => $validated->generic_name,
        "reorder_level" => $validated->reorder_level,
        "shelf_id" => $validated->shelf,
        "has_expiry" => $validated->has_expiry,
        "supplier_id" => $validated->supplier ?: NULL,
        "manufacturer_id" => $validated->manufacturer ?: NULL,
        "product_type_id" => $validated->product_type ?: NULL,
        "description" => $validated->description ?: NULL,
        "side_effects" => $validated->side_effects ?: NULL,
        "barcode" => $validated->barcode ?: NULL,
        "product_number" => $validated->product_number ?: NULL,
        "slug" => Str::slug($validated->generic_name)
      ]);

      if ($product) {
        // Attach categories to product
        $product->categories()->attach($validated->categories);

        if ($request->hasFile("images")) {
          foreach ($request->file('images') as $image) {
            $product->addMedia($image)->toMediaCollection('images');
          }
        }
        DB::commit();
        // TODO: Fire event for websocket
        $product = $product->with("categories")->with("media")->first();
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
   * @param string $mask
   * @return JsonResponse
   */
  public function show(string $mask): JsonResponse
  {
    try {
      $product = Product::with("manufacturer")
        ->with("supplier")
        ->with("shelf")
        ->with("media")
        ->with("categories")
        ->where("mask", $mask)
        ->firstOrFail();

//      $product = Product::with("productCategory")->where("mask", $mask)->firstOrFail();

      return $this->dataResponse($product);
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
        "has_expiry" => $validated->has_expiry,
        "reorder_level" => $validated->reorder_level,
        "shelf_id" => $request->shelf ?: NULL,
        "supplier_id" => $validated->supplier,
        "manufacturer_id" => $request->manufacturer ?: NULL,
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
          foreach ($request->file('images') as $image) {
            $product->addMedia($image)->toMediaCollection('images');
          }
        }

        DB::commit();
        // TODO: Fire event for websocket
        $product = $product->with("categories")->with("media")->first();
        return $this->successDataResponse($product, "Product updated successfully");
      }
      DB::rollBack();
      return $this->errorResponse("An error occurred while updating this product");
    } catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    } catch (Exception $e) {
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

  public function deleteFile(int $fileId): JsonResponse
  {
    try {

    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function search(Request $request): JsonResponse
  {
    try {
      $query = trim($request->input("search_term") ?: "");
      $results = Product::search(strtolower($query));
      return $this->dataResponse($results);
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}
