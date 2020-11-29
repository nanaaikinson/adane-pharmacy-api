<?php

namespace App\Http\Controllers\API\Admin;

use App\Functions\Mask;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Exception;

class CustomerController extends Controller
{
  use ResponseTrait;

  public function index(): JsonResponse
  {
    try {
      $customers = Customer::orderBy("id", "DESC")->get();
      return $this->dataResponse($customers);
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function store(StoreCustomerRequest $request): JsonResponse
  {
    try {
      $customer = $this->saveCustomerRecord([
        "first_name" => $request->input("first_name"),
        "last_name" => $request->input("last_name"),
        "email" => $request->input("email") ?: NULL,
        "phone_number" => $request->input("phone_number") ?: NULL,
        "height" => $request->input("height") ?: NULL,
        "weight" => $request->input("weight") ?: NULL,
        "date_of_birth" => $request->input("date_of_birth") ?: NULL,
        "allergies" => $request->input("allergies") ?: NULL,
        "others" => $request->input("others"),
        "mask" => Mask::integer(),
      ]);

      if ($customer) {
        return $this->successResponse("Customer created successfully");
      }
      return $this->errorResponse("An error occurred while saving this record");
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function show(string $mask): JsonResponse
  {
    try {
      $customer = Customer::where("mask", $mask)->firstOrFail();
      return $this->dataResponse($customer);
    }
    catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function update(StoreCustomerRequest $request, string $mask): JsonResponse
  {
    try {
      $customer = Customer::where("mask", $mask)->firstOrFail();
      $updated = $customer->update([
        "first_name" => $request->input("first_name"),
        "last_name" => $request->input("last_name"),
        "email" => $request->input("email") ?: NULL,
        "phone_number" => $request->input("phone_number") ?: NULL,
        "height" => $request->input("height") ?: NULL,
        "weight" => $request->input("weight") ?: NULL,
        "date_of_birth" => $request->input("date_of_birth") ?: NULL,
        "allergies" => $request->input("allergies") ?: NULL,
        "others" => $request->input("others"),
      ]);

      if ($updated) {
        return $this->successResponse("Customer updated successfully");
      }

      return $this->errorResponse("An error occurred while updating this customer");
    }
    catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function saveCustomerRecord($data) {
    return Customer::create($data);
  }
}
