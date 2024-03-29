<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
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
      "name" => "required",
      "amount" => "required|regex:/^\d+(\.\d{1,2})?$/"
    ];
  }

  public function messages(): array
  {
    return [
      "regex" => "The price entered must be a valid money"
    ];
  }
}
