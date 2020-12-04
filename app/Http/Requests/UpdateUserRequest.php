<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

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
    $user = User::where("mask", $this->route("mask"))->first();

    return [
      "first_name" => "required",
      "last_name" => "required",
      "email" => "required|unique:users,email," . $user->id,
      "username" => "required|unique:users,username," . $user->id,
      //"username" => ["required", Rule::unique("users")->ignore($this->route("mask"), "mask")],
      "role" => "required|exists:roles,id"
    ];
  }
}
