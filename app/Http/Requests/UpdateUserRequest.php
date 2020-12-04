<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      "first_name" => "required",
      "last_name" => "required",
      "email" => ["required", Rule::unique("users")->ignore($this->route("mask"), "mask")],
      "username" => ["required", Rule::unique("users")->ignore($this->route("mask"), "mask")],
      "role" => "required|exists:roles,id"
    ];
  }
}
