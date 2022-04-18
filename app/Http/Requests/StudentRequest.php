<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
      'last_name' => 'required|string',
      'email' => 'required|string|email',
      'name' => 'required|string',
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
      'email.required' => __('common.fieldIsRequired', ['field' => __('auth.email')]),
      'name.required' => __('common.fieldIsRequired', ['field' => __('auth.email')]),
      'last_name.required' => __('common.fieldIsRequired', ['field' => __('auth.password')]),
    ];
  }
}
