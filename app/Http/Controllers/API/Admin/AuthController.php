<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{
  use ResponseTrait;

  /**
   * Login user
   *
   * @param AdminLoginRequest $request
   * @return JsonResponse
   */
  public function login(AdminLoginRequest $request): JsonResponse
  {
    try {
      $username = $request->input("username");
      $password = $request->input("password");

      if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
        //user sent their email
        Auth::attempt(['email' => $username, 'password' => $password]);
      } else {
        //they sent their username instead
        Auth::attempt(['username' => $username, 'password' => $password]);
      }

      if (Auth::check()) {
        $user = Auth::user();
        $token = $user->createToken("Admin Login")->accessToken;
        $permissions = $user->allPermissions()->pluck("name");

        return $this->dataResponse([
          "name" => $user->name,
          "permissions" => $permissions,
          "token" => $token
        ]);
      }
      return $this->errorResponse("Incorrect credentials provided");
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function resetPassword(Request $request)
  {
    request()->validate($request->all(), ["username" => "required"]);
  }

  public function user(Request $request): JsonResponse
  {
    return $this->dataResponse($request->user());
  }

  /**
   * Logout current authenticated user
   *
   * @authenticated
   * @param Request $request
   * @return JsonResponse
   */
  public function logout(Request $request): JsonResponse
  {
    $user = $request->user()->token();
    $user->revoke();

    return $this->successResponse("Logout successful");
  }
}
