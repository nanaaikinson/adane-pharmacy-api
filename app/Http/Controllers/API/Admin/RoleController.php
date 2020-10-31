<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class RoleController extends Controller
{
  use ResponseTrait;

  public function index(): JsonResponse
  {
    try {
      $roles = Role::orderBy("id", "DESC")->get();
      return $this->dataResponse($roles);
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }


  public function store(Request $request)
  {
    //
  }


  public function show($id)
  {
    //
  }


  public function update(Request $request, $id)
  {
    //
  }


  public function destroy($id)
  {
    //
  }
}
