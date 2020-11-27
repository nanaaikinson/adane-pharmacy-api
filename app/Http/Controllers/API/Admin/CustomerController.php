<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
  use ResponseTrait;

  public function index(): JsonResponse
  {
    try {
      $customers = Customer::all();
      return $this->dataResponse($customers);
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function store(StoreCustomerRequest $request): JsonResponse
  {
    try {
      $validated = (object)$request->validationData();
      $customer = Customer::create([

      ]);
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}
