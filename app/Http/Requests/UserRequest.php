<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
      'avatar' => 'nullable|image',
      'personal_id' => 'required|integer',
      'name' => 'required|string|max:255',
      'lastname' => 'required|string|max:255',
      'email' => 'required|email|unique:users',
      'date_of_birth' => 'required|date',
      'is_admin' => 'boolean',
      'password' => 'required_if:is_admin,1|confirmed|string|max:255',
    ];
  }
}
