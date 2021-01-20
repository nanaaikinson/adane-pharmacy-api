<?php

namespace App\Http\Controllers\API\Admin;

use App\Functions\Mask;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Models\Expense;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
  use ResponseTrait;

  public function index(Request $request): JsonResponse
  {
    return $this->dataResponse(Expense::all());
  }

  public function store(StoreExpenseRequest $request): JsonResponse
  {
    try {
      $expense = Expense::create([
        "name" => $request->input("name"),
        "amount" => $request->input("amount"),
        "note" => $request->input("note"),
        "mask" => Mask::integer()
      ]);

      return $this->successDataResponse($expense, "Expense created successfully.");
    }
    catch (\Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function show(string $mask): JsonResponse
  {
    try {
      $expense = Expense::where("mask", $mask)->firstOrFail();
      return $this->dataResponse($expense);
    }
    catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    }
    catch (\Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function update(StoreExpenseRequest $request, string $mask): JsonResponse
  {
    try {
      $expense = Expense::where("mask", $mask)->firstOrFail();
      $expense->update([
        "name" => $request->input("name"),
        "amount" => $request->input("amount"),
        "note" => $request->input("note"),
      ]);

      return $this->successDataResponse($expense, "Expense updated successfully.");
    }
    catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    }
    catch (\Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function destroy(string $mask): JsonResponse
  {
    try {
      $expense = Expense::where("mask", $mask)->firstOrFail();
      $expense->delete();

      return $this->successResponse("Expense deleted successfully.");
    }
    catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    }
    catch (\Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}
