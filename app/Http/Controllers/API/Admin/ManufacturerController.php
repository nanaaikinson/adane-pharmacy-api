<?php

namespace App\Http\Controllers\API\Admin;

use App\Events\BrandsRealtimeEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Models\Manufacturer;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
  use ResponseTrait;

  public function index(Request $request): JsonResponse
  {
    try {
      $brands = Manufacturer::orderBy("id", "DESC")->get();
      return $this->dataResponse($brands);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function store(StoreBrandRequest $request): JsonResponse
  {
    try {
      $validated = (object)$request->validationData();
      $brand = Manufacturer::create([
        "name" => $validated->name,
        "description" => $request->input("description") ?: NULL,
      ]);

      // Emit realtime event
      // event(new BrandsRealtimeEvent($brand, env("WS_CHANNEL"), env("EVENT_BRAND"), "store"));

      $message = "Manufacturer created successfully";
      return $this->successDataResponse($brand, $message);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function show(string $mask): JsonResponse
  {
    try {
      $brand = Manufacturer::where("mask", $mask)->firstOrFail();
      return $this->dataResponse($brand);
    } catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function update(StoreBrandRequest $request, string $mask): JsonResponse
  {
    try {
      $brand = Manufacturer::where("mask", $mask)->firstOrFail();
      $validated = (object)$request->validationData();
      $brand->update([
        "name" => $validated->name,
        "description" => $request->input("description") ?: NULL,
      ]);
      $message = "Manufacturer updated successfully";
      return $this->successDataResponse($brand, $message);
    } catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function destroy(string $mask)
  {

  }
}
