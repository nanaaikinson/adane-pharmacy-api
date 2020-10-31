<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
      "email" => "required|unique:users,email",
      "username" => "required|unique:users,username",
      "password" => "required|min:6|max:20",
      "role" => "required|exists:roles,id"
    ];
  }
}
