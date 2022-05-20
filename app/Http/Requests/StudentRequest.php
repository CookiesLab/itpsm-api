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
      'name' => 'required|string|max:255',
      'last_name' => 'required|string|max:255',
      'email' => 'required|string|email',
      'gender' => 'required',
      'relationship' => 'required',
      'status' => 'required',
      'municipality_id' => 'required',
      'department_id' => 'required',
      'country_id' => 'required',
      'entry_date' => 'required|integer',
      'entry_period' => 'required',
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
      'carnet.required' => 'El campo carnet es obligatorio',
      'name.required' => 'El campo nombre es obligatorio',
      'last_name.required' => 'El campo last_name es obligatorio',
      'email.required' => 'El campo email es obligatorio',
      'gender.required' => 'El campo gender es obligatorio',
      'relationship.required' => 'El campo relationship es obligatorio',
      'status.required' => 'El campo status es obligatorio',
      'municipality_id.required' => 'El campo municipality_id es obligatorio',
      'department_id.required' => 'El campo department_id es obligatorio',
      'country_id.required' => 'El campo country_id es obligatorio',
    ];
  }
}
