<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MunicipalityRequest extends FormRequest
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
            'department_id' => 'required',
            'country_id' => 'required',
        ];
    }

    public function messages()
    {
      return [
          'name.required' => 'El campo name es obligatorio',
          'department_id.required' => 'El campo department_id es obligatorio',
          'country_id.required' => 'El campo country_id es obligatorio',
      ];
    }
}
