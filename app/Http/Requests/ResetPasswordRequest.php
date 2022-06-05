<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
      'password' => 'required|string|min:8',
      'system_reference_table' => 'required',
      'system_reference_id' => 'required'
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
      'password.required' => 'La contraseña es requerida',
      'password.min' => 'La contraseña debe tener mínimo 8 dígitos',
      'reference_table' => 'El campo tabla de referencia es obligatorio',
      'reference_id' => 'El campo Id de referencia es obligatorio'
    ];
  }
}
