<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductTypeRequest;
use App\Models\ProductType;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class ProductTypeController extends Controller
{
  use ResponseTrait;

  public function index(Request $request): JsonResponse
  {
    try {
      $ProductTypes = ProductType::orderBy("id", "DESC")->get();
      return $this->dataResponse($ProductTypes);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function store(StoreProductTypeRequest $request): JsonResponse
  {
    try {
      $validated = (object)$request->validationData();
      $ProductType = ProductType::create([
        "name" => $validated->name,
        "description" => $request->input("description") ?: NULL,
      ]);
      $message = "Product type created successfully";
      return $this->successDataResponse($ProductType, $message);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function show(string $mask): JsonResponse
  {
    try {
      $ProductType = ProductType::where("mask", $mask)->firstOrFail();
      return $this->dataResponse($ProductType);
    } catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function update(StoreProductTypeRequest $request, string $mask): JsonResponse
  {
    try {
      $ProductType = ProductType::where("mask", $mask)->firstOrFail();
      $validated = (object)$request->validationData();
      $ProductType->update([
        "name" => $validated->name,
        "description" => $request->input("description") ?: NULL,
      ]);
      $message = "Product type updated successfully";
      return $this->successDataResponse($ProductType, $message);
    } catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function destroy(string $mask): JsonResponse
  {
    try {
      $shelf = ProductType::where("mask", $mask)->firstOrFail();
      $shelf->delete();
      return $this->successResponse("Product type deleted successfully.");
    }
    catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}
