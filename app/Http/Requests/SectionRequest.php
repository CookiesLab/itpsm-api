<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
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
            'quota' => 'required|integer',
            'start_week' => 'required|integer',
            'end_week' => 'required|integer',
            'teacher_id' => 'required|integer',
           
            'curriculum_subject_id' => 'required',
            'period_id' => 'required',
        ];
    }

    public function messages()
    {
      return [
          'quota.required' => 'El campo quota es obligatorio',
         
          'curriculum_subject_id.required' => 'El campo Materia es obligatorio',
          'period_id.required' => 'El campo ciclo es obligatorio',
          'start_week' => 'La semana de inicio es obligatoria',
          'end_week' => 'La semana de inicio es obligatoria',
          'teacher_id' => 'La semana de inicio es obligatoria',
      ];
    }
}
