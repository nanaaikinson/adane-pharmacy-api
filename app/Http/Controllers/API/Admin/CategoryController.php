<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  use ResponseTrait;

  public function index(Request $request): JsonResponse
  {
    try {
      $categories = Category::index();
      return $this->dataResponse($categories);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function store(StoreCategoryRequest $request): JsonResponse
  {
    try {
      $validated = (object)$request->validationData();
      $category = Category::create([
        "name" => $validated->name,
        "description" => $request->input("description") ?: NULL,
      ]);
      $message = "Category created successfully";
      return $this->successDataResponse($category, $message);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function show(string $mask): JsonResponse
  {
    try {
      $category = Category::where("mask", $mask)->firstOrFail();
      return $this->dataResponse($category);
    } catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function update(StoreCategoryRequest $request, string $mask): JsonResponse
  {
    try {
      $category = Category::where("mask", $mask)->firstOrFail();
      $validated = (object)$request->validationData();
      $category->update([
        "name" => $validated->name,
        "description" => $request->input("description") ?: NULL,
      ]);
      $message = "Category updated successfully";
      return $this->successDataResponse($category, $message);
    } catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function destroy(string $mask): JsonResponse
  {
    try {
      $shelf = Category::where("mask", $mask)->firstOrFail();
      $shelf->delete();
      return $this->successResponse("Category deleted successfully.");
    }
    catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function destroyMultipleUsingId(Request $request): JsonResponse
  {
    try {
      Category::query()->whereIn("id", $request->input("categories"))->delete();
      return $this->successResponse("Selected categories deleted successfully.");
    } catch (\Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}
