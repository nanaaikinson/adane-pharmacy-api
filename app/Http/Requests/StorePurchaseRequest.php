<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
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
      "supplier" => "required|exists:suppliers,id",
      "purchase_date" => "required|date|date_format:Y-m-d",
      "invoice_number" => "required",
      "details" => "nullable",
      "items" => "required|array",
      "items.*.product_id" => "required|exists:products,id",
      "items.*.expiry_date" => "required|date|date_format:Y-m-d",
      "items.*.quantity" => "required|numeric|min:1",
      "items.*.cost_price" => "required|regex:/^\d+(\.\d{1,2})?$/",
      "items.*.selling_price" => "required|regex:/^\d+(\.\d{1,2})?$/",
    ];
  }

  public function messages(): array
  {
    return [
      "regex" => "The cost price entered must be a valid money"
    ];
  }
}
