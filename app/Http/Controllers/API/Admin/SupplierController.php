<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Models\Supplier;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

class SupplierController extends Controller
{
  use ResponseTrait;

  public function index(Request $request): JsonResponse
  {
    try {
      return $this->dataResponse(Supplier::orderBy("id", "DESC")->get());
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function store(StoreSupplierRequest $request): JsonResponse
  {
    try {
      $validated = (object)$request->validationData();
      $supplier = Supplier::create([
        "name" => $validated->name,
        "email" => $request->input("email") ?: NULL,
        "primary_telephone" => $request->input("primary_telephone") ?: NULL,
        "secondary_telephone" => $request->input("secondary_telephone") ?: NULL,
        "description" => $request->input("description") ?: NULL,
      ]);
      if ($request->hasFile('image')) {
        $supplier->addMediaFromRequest('image')->toMediaCollection('images');
      }
      return $this->successDataResponse($supplier, "Supplier created successfully.");
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function show(string $mask): JsonResponse
  {
    try {
      $supplier = Supplier::where("mask", $mask)->firstOrFail();
      return $this->dataResponse($supplier);
    } catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function update(StoreSupplierRequest $request, string $mask): JsonResponse
  {
    try {
      $supplier = Supplier::where("mask", $mask)->firstOrFail();
      $validated = (object)$request->validationData();
      $supplier->update([
        "name" => $validated->name,
        "email" => $request->input("email") ?: NULL,
        "primary_telephone" => $request->input("primary_telephone") ?: NULL,
        "secondary_telephone" => $request->input("secondary_telephone") ?: NULL,
        "description" => $request->input("description") ?: NULL,
      ]);
      $message = "Supplier updated successfully.";
      return $this->successDataResponse($supplier, $message);
    } catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function destroy(): JsonResponse
  {

  }
}
