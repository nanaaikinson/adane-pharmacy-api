<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
      'name' => 'required',
      'primary_telephone' => 'nullable|min:10|numeric',
      'secondary_telephone' => 'nullable|min:10|numeric',
      'email' => 'nullable|email',
      'image' => 'nullable|mimes:jpeg,jpg,png|max:2048'
    ];
  }
}
