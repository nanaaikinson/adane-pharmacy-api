<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShelfRequest;
use App\Models\Shelf;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class ShelfController extends Controller
{
  use ResponseTrait;

  /**
   * Display a listing of the resource.
   *
   * @return JsonResponse
   */
  public function index():JsonResponse
  {
    return $this->dataResponse(Shelf::orderBy("id", "DESC")->get());
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param StoreShelfRequest $request
   * @return JsonResponse
   */
  public function store(StoreShelfRequest $request): JsonResponse
  {
    try {
      $validated = (object)$request->validationData();
      $shelf = Shelf::create([
        "name" => $validated->name,
        "number" => $request->input("numeric_number") ?: NULL,
        "description" => $request->input("description") ?: NULL,
      ]);
      return $this->successDataResponse($shelf, "Shelf saved successfully");
    }
    catch (Exception $e) {
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
      $shelf = Shelf::where("mask", $mask)->firstOrFail();
      return $this->dataResponse($shelf);
    }
    catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param StoreShelfRequest $request
   * @param $mask
   * @return JsonResponse
   */
  public function update(StoreShelfRequest $request, $mask): JsonResponse
  {
    try {
      $shelf = Shelf::where("mask", $mask)->firstOrFail();
      $validated = (object)$request->validationData();
      $shelf->update([
        "name" => $validated->name,
        "number" => $request->input("numeric_number") ?: NULL,
        "description" => $request->input("description") ?: NULL,
      ]);
      return $this->successDataResponse($shelf, "Shelf updated successfully.");
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
   * @param $mask
   * @return JsonResponse
   */
  public function destroy($mask): JsonResponse
  {
    try {
      $shelf = Shelf::where("mask", $mask)->firstOrFail();
      $shelf->delete();
      return $this->successResponse("Shelf deleted successfully.");
    }
    catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}
