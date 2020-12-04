<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RoleController extends Controller
{
  use ResponseTrait;

  public function index(): JsonResponse
  {
    try {
      $roles = Role::where("id", "<>", "1")->orderBy("id", "DESC")->get();
      return $this->dataResponse($roles);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }


  public function store(Request $request)
  {
    //
  }


  public function show($mask): JsonResponse
  {
    try {
      $role = Role::where("mask", (int)$mask)->firstOrFail();
      $permissions = $role->permissions->pluck("id");

      return $this->dataResponse([
        "mask" => (int)$role->mask,
        "name" => $role->display_name,
        "description" => $role->description,
        "permissions" => $permissions
      ]);
    } catch (ModelNotFoundException $e) {
      return $this->notFoundResponse("No results for this");
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function update(Request $request, $mask): JsonResponse
  {
    try {
      $role = Role::where("mask", (int)$mask)->firstOrFail();

      $rules = ["name" => "required|unique:roles,name,{$role->id},id", "permissions" => "required"];
      $validator = Validator::make($request->all(), $rules, ["unique" => "You already have a role with the same name."]);
      if ($validator->fails()) return $this->validationResponse((array)$validator->errors());

      // Process Data
      $role->name = Str::slug($request->input('name'));
      $role->display_name = $request->input("name");
      $role->description = $request->input("description") ?: null;

      if ($role->save()) {
        $role->syncPermissions($request->input("permissions"));
        return $this->successResponse("Role updated successfully.");
      }
      return $this->errorResponse("An error occurred while updating this role.");
    } catch (ModelNotFoundException $e) {
      return $this->notFoundResponse("No results for this");
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }


  public function destroy($id)
  {
    //
  }

  public function permissions(): JsonResponse
  {
    return $this->dataResponse(Permission::select("id", "display_name")->get());
  }
}
