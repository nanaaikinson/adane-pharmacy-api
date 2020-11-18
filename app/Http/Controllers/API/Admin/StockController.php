<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StockController extends Controller
{
  use ResponseTrait;

  /**
   * List stock items
   *
   * @return JsonResponse
   */
  public function index(): JsonResponse
  {

  }
}
