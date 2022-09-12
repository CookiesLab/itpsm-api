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
            'student_id' => 'required|numeric',
            'teacher_id' => 'numeric',
            'curriculum_subject_id' => 'required|numeric',
            'period_id' => 'required|numeric',
            'code' => 'required|numeric',
            'final_score' => 'numeric',
            'is_approved' => 'integer',
            'enrollment' => 'integer'
        ];
    }

    public function messages()
    {
      return [

      ];
    }
}
