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
            'cum' => 'required|float',
            'entry_year' => 'required|integer',
            'student_id' => 'required',
            'curriculum_id' => 'required',
            'scholarship_id' => 'required',
        ];
    }

    public function messages()
    {
      return [
          'cum.required' => 'El campo cum es obligatorio',
          'entry_year.required' => 'El campo entry_year es obligatorio',
          'student_id.required' => 'El campo student_id es obligatorio',
          'curriculum_id.required' => 'El campo curriculum_id es obligatorio',
          'scholarship_id.required' => 'El campo scholarship_id es obligatorio',
      ];
    }
}
