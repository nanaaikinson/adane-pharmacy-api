<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FileController extends Controller
{
  use ResponseTrait;

  public function destroy(int $fileId): JsonResponse
  {
    try {
      $file = Media::where("id", $fileId)->firstOrFail();
      if ($file->delete()) {
        return $this->successResponse("File deleted successfully");
      }
      return $this->errorResponse("An error occurred while deleting this file");
    } catch (ModelNotFoundException $e) {
      return $this->notFoundResponse();
    } catch (Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}
