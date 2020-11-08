<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequest;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class PurchaseController extends Controller
{
  use ResponseTrait;

  public function store(StorePurchaseRequest $request): JsonResponse
  {
    try {
      $validated = (object)$request->validationData();
      dd($validated);
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}
