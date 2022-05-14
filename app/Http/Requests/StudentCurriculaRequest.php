<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentCurriculaRequest extends FormRequest
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
            'cum' => 'required|numeric',
            'entry_year' => 'required|integer',
        ];
    }

    public function messages()
    {
      return [
          'cum.required' => 'El campo cum es obligatorio',
          'entry_year.required' => 'El campo entry_year es obligatorio',
      ];
    }
}
