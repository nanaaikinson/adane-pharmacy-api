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
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Fuse\Fuse;

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
          $media = ($product->media->map(function($file) {
            return [
              "file_id" => $file->id,
              "url" => $file->getFullUrl(),
              "file_name" => $file->file_name,
            ];
          }));

          return [
            "id" => (int)$product->id,
            "mask" => $product->mask,
            "selling_price" => $product->selling_price,
            "brand_name" => $product->brand_name,
            "generic_name" => $product->generic_name,
            "quantity" => $product->quantity,
            "has_expiry" => $product->has_expiry,
            "reorder_level" => $product->reorder_level,
            "supplier" => $product->supplier ? $product->supplier->name : NULL,
            "manufacturer" => $product->manufacturer ? $product->manufacturer->name : NULL,
            "shelf" => $product->shelf ? $product->shelf->name : NULL,
            "images" => $images,
            "media" => $media,
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
        "shelf_id" => $request->shelf ?: NULL,
        "has_expiry" => $request->has_expiry ?: 0,
        "supplier_id" => $request->supplier ?: NULL,
        "manufacturer_id" => $request->manufacturer ?: NULL,
        "product_type_id" => $request->product_type ?: NULL,
        "description" => $request->description ?: NULL,
        "side_effects" => $request->side_effects ?: NULL,
        "barcode" => $request->barcode ?: NULL,
        "product_number" => $request->product_number ?: NULL,
        "slug" => Str::slug($request->generic_name)
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
        ->with("categories")
        ->where("mask", $mask)
        ->firstOrFail();

      $images = ($product->media->map(function($file) {
        return [
          "file_id" => $file->id,
          "url" => $file->getFullUrl(),
          "file_name" => $file->file_name,
        ];
      }));

      $product->setAttribute("images", $images);
      unset($product->media);

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
      $validated = (object)$request->validationData();
      DB::beginTransaction();

      $updated = $product->update([
        "brand_name" => $validated->brand_name,
        "generic_name" => $validated->generic_name,
        "reorder_level" => $validated->reorder_level,
        "shelf_id" => $request->shelf ?: NULL,
        "has_expiry" => $request->has_expiry ?: 0,
        "supplier_id" => $request->supplier ?: NULL,
        "manufacturer_id" => $request->manufacturer ?: NULL,
        "product_type_id" => $request->product_type ?: NULL,
        "description" => $request->description ?: NULL,
        "side_effects" => $request->side_effects ?: NULL,
        "barcode" => $request->barcode ?: NULL,
        "product_number" => $request->product_number ?: NULL,
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


  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function search(Request $request): JsonResponse
  {
    try {
      $query = trim(strtolower($request->input("search_term") ?: ""));
      if ($query) {
        $results = Product::with("supplier")
          ->with("manufacturer")
          ->with("categories")
          ->with("media")
          ->with("type")->get()
          ->map(function($product) {

            return [
              "id" => $product->id,
              "generic_name" => $product->generic_name,
              "brand_name" => $product->brand_name,
              "mask" => $product->mask,
              "supplier" => $product->supplier ? $product->supplier->name : NULL,
              "manufacturer" => $product->manufacturer ? $product->manufacturer->name : NULL,
              "type" => $product->type ? $product->type->name : NULL,
              "quantity" => $product->quantity,
              "selling_price" => $product->selling_price,
              "categories" => $product->categories->isNotEmpty() ? $product->categories->map(function ($cat) {
                return $cat->name;
              }) : [],
              "media" => $product->media->isNotEmpty() ? $product->media->map(function ($file) {
                return $file->getFullUrl();
              }) : [],
            ];
          });

        $fuse = new Fuse($results->toArray(), [
          "keys" => [
            "generic_name",
            "brand_name",
            "supplier",
            "manufacturer",
            "type",
          ]
        ]);
        return $this->dataResponse($fuse->search($query));
      }
      return $this->dataResponse([]);

    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function batch(string $mask): JsonResponse
  {
    try {
      $product = Product::with("purchaseItem")
      ->where("mask", $mask)->firstOrFail();

      return $this->dataResponse($product);
    }
    catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}
