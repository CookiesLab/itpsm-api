<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EvaluationRequest extends FormRequest
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
            'date' => 'required',
            'percentage' => 'required',
            'section_id' => 'required',
        ];
    }

    public function messages()
    {
      return [
          'name.required' => 'El campo name es obligatorio',
          'date.required' => 'El campo date es obligatorio',
          'percentage.required' => 'El campo percentage es obligatorio',
          'section_id.required' => 'El campo seccion es obligatorio',
      ];
    }
}
