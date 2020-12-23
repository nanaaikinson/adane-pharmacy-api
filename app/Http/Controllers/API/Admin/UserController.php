<?php

namespace App\Http\Controllers\API\Admin;

use App\Functions\Mask;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psy\Util\Json;

class UserController extends Controller
{
  use ResponseTrait;

  public function index(): JsonResponse
  {
    try {
      $users = User::with("role")
        ->where("id", "<>", 1)
        ->orderBy("id", "DESC")->get();
      return $this->dataResponse($users);
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function store(StoreUserRequest $request): JsonResponse
  {
    try {
      $validated = (object)$request->validationData();
      $user = User::create([
        "first_name" => $validated->first_name,
        "last_name" => $validated->last_name,
        "email" => $validated->email,
        "username" => $validated->username,
        "password" => bcrypt($validated->password),
        "role_id" => $validated->role,
        "mask" => Mask::integer(),
      ]);

      if ($user) {
        $user->attachRole($validated->role);

        return $this->successDataResponse($user, "User saved successfully");
      }
      return $this->errorResponse("An error occurred while saving this user");
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function show(string $mask): JsonResponse
  {
    try {
      $user = User::where("mask", $mask)->firstOrFail();
      return $this->dataResponse($user);
    }
    catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function update(UpdateUserRequest $request, string $mask): JsonResponse
  {
    try {
      $user = User::where("mask", $mask)->firstOrFail();
      $validated = (object)$request->validationData();
      $user->update([
        "first_name" => $validated->first_name,
        "last_name" => $validated->last_name,
        "email" => $validated->email,
        "username" => $validated->username,
        "role_id" => $validated->role
      ]);

      if ($user) {
        $user->syncRoles([$validated->role]);

        return $this->successDataResponse($user, "User updated successfully");
      }
      return $this->errorResponse("An error occurred while updating this user");
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function destroy(string $mask): JsonResponse
  {
    try {
      $user = User::where("mask", $mask)->firstOrFail();

      if ($user->delete()) {
        $user->detachRole($user->role_id);

        return $this->successDataResponse($user, "User updated successfully");
      }
      return $this->errorResponse("An error occurred while updating this user");
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function passwordUpdate(Request $request, string $mask): JsonResponse
  {
    try {

    }
    catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    }
    catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}
