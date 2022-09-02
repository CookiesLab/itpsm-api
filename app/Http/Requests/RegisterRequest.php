<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
      'name' => 'required|string',
      'email' => 'required|string|email|unique:users',
      'password' => 'required|string|min:8',
      'role_id' => 'required|integer|exists:roles,id'
    ];
  }

  /**
   * Custom message for validation
   *
   * @return array
   */
  public function messages()
  {
    return [
      'name.required' => __('common.fieldIsRequired', ['field' => __('auth.name')]),
      'email.required' => __('common.fieldIsRequired', ['field' => __('auth.email')]),
      'password.required' => __('common.fieldIsRequired', ['field' => __('auth.password')]),
      'role_id.required' => __('common.fieldIsRequired', ['field' => __('auth.role_id')]),

      'role_id.integer' => __('common.fieldIsInteger', ['field' => __('auth.role_id')]),
      'role_id.exists' => __('common.idExists', ['id' => __('auth.role_id')]),


      'email.unique' => __('auth.emailUnique'),
      'password.min' => __('auth.passwordMin')
    ];
  }
}
