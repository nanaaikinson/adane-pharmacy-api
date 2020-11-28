<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Traits\ResponseTrait;
use Exception;

class SalesController extends Controller
{
  use ResponseTrait;

  public function order(StoreOrderRequest $request)
  {
    try {

    }
    catch (Exception $e) {

    }
  }
}
