<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreManufacturerRequest;
use App\Models\Manufacturer;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class ManufacturerController extends Controller
{
  use ResponseTrait;

  public function index(Request $request): JsonResponse
  {
    try {
      $manufacturers = Manufacturer::orderBy("id", "DESC")->get();
      return $this->dataResponse($manufacturers);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function store(StoreManufacturerRequest $request): JsonResponse
  {
    try {
      $validated = (object)$request->validationData();
      $Manufacturer = Manufacturer::create([
        "name" => $validated->name,
        "description" => $request->input("description") ?: NULL,
      ]);
      $message = "Manufacturer created successfully";
      return $this->successDataResponse($Manufacturer, $message);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function show(string $mask): JsonResponse
  {
    try {
      $Manufacturer = Manufacturer::where("mask", $mask)->firstOrFail();
      return $this->dataResponse($Manufacturer);
    } catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function update(StoreManufacturerRequest $request, string $mask): JsonResponse
  {
    try {
      $Manufacturer = Manufacturer::where("mask", $mask)->firstOrFail();
      $validated = (object)$request->validationData();
      $Manufacturer->update([
        "name" => $validated->name,
        "description" => $request->input("description") ?: NULL,
      ]);
      $message = "Manufacturer updated successfully";
      return $this->successDataResponse($Manufacturer, $message);
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
