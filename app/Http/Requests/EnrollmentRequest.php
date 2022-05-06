<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnrollmentRequest extends FormRequest
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
            'final_score' => 'required|float',
            'is_approved' => 'required|boolean',
            'enrollment' => 'required|integer',
            'curriculum_subject_id' => 'required',
            'period_id' => 'required',
            'code' => 'required',
            'student_id' => 'required',
            'teacher_id' => 'required',
        ];
    }

    public function messages()
    {
      return [
          'final_score.required' => 'El campo final_score es obligatorio',
          'is_approved.required' => 'El campo is_approved es obligatorio',
          'enrollment.required' => 'El campo enrollment es obligatorio',
          'curriculum_subject_id.required' => 'El campo curriculum_subject_id es obligatorio',
          'period_id.required' => 'El campo period_id es obligatorio',
          'code.required' => 'El campo code es obligatorio',
          'student_id.required' => 'El campo student_id es obligatorio',
          'teacher_id.required' => 'El campo teacher_id es obligatorio',
      ];
    }
}
