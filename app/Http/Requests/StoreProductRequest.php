<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules(): array
  {
    return [
      "generic_name" => "required",
      "brand_name" => "required",
      "categories" => "required|array|min:1",
      "categories.*" => "exists:categories,id",

      "has_expiry" => "required",
      "reorder_level" => "required|integer",
      "product_type" => "required|exists:product_types,id",
      "supplier" => "required|exists:suppliers,id",

      //"expiry_date" => "required_if:has_expiry,1|date|date_format:Y-m-d",

      "shelf" => "nullable|exists:shelves,id",
      "manufacturer" => "nullable|exists:manufacturers,id",
      "description" => "nullable",
      "side_effects" => "nullable",
      "barcode" => "nullable",
      "product_number" => "nullable",
      "discount" => "nullable|integer",

      "images" => "nullable|array",
      "images.*" => "mimes:jpeg,jpg,png|max:2048"
    ];
  }
}
