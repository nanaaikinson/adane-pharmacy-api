<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait {

  /**
   * Data response
   *
   * @param mixed $data
   * @return JsonResponse
   */
  public function dataResponse($data): JsonResponse
  {
    $response = [
      'code' => 200,
      'status' => 'success',
      'data' => $data,
    ];

    return response()->json($response, $response['code']);
  }

  /**
   * Data response
   *
   * @param mixed $data
   * @param string $message
   * @return JsonResponse
   */
  public function successDataResponse($data, string $message): JsonResponse
  {
    $response = [
      'code' => 200,
      'status' => 'success',
      'message' => $message,
      'data' => $data,
    ];

    return response()->json($response, $response['code']);
  }

  /**
   * Validation errors response
   *
   * @param array $errors
   * @return JsonResponse
   */
  public function validationResponse(array $errors): JsonResponse
  {
    $response = [
      'status' => 'validation error',
      'code' => 422,
      'errors' => $errors,
    ];

    return response()->json($response, $response['code']);
  }

  /**
   * Unauthorized response
   *
   * @param string $message
   * @return JsonResponse
   */
  public function unauthorizedResponse($message = "Unauthorized"): JsonResponse
  {
    $response = [
      'code' => 401,
      'status' => 'unauthorized',
      'message' => $message
    ];
    return response()->json($response, $response['code']);
  }

  /**
   * Success response with only message
   *
   * @param string $message
   * @return JsonResponse
   */
  protected function successResponse(string $message): JsonResponse
  {
    $response = [
      'code' => 200,
      'status' => 'success',
      'message' => $message,
    ];
    return response()->json($response, $response['code']);
  }

  /**
   * Error response
   *
   * @param mixed $message
   * @return JsonResponse
   */
  public function errorResponse($message): JsonResponse
  {
    $response = [
      'code' => 400,
      'status' => 'error',
      'message' => $message,
    ];

    return response()->json($response, $response['code']);
  }

  /**
   * Error response
   *
   * @param string $message
   * @return JsonResponse
   */
  public function notFoundResponse(string $message = "No resource found"): JsonResponse
  {
    $response = [
      'code' => 404,
      'status' => 'error',
      'message' => $message,
    ];

    return response()->json($response, $response['code']);
  }
}
