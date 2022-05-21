<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
            'birth_date' => 'required|string|date_format:Y-m-d',
            'dui' => 'required|string',
            'email' => 'required|string|max:255',
            'genre' => 'required|string',
            'municipality_id' => 'required',
            'department_id' => 'required',
            'country_id' => 'required',
            'status_id' => 'required',
        ];
    }

    public function messages()
  {
    return [
      'name.required' => 'El campo nombre es obligatorio',
      'last_name.required' => 'El campo apellido es obligatorio',
      'birth_date.required' => 'El campo fecha de nacimiento es obligatorio',
      'dui.required' => 'El campo DUI es obligatorio',
      'email.required' => 'El campo correo electrónico es obligatorio',
      'genre.required' => 'El campo género es obligatorio',
      'municipality_id.required' => 'El campo municipality_id es obligatorio',
      'department_id.required' => 'El campo department_id es obligatorio',
      'country_id.required' => 'El campo country_id es obligatorio',
      'status_id.required' => 'El campo status_id es obligatorio',
    ];
  }
}
