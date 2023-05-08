<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcademicHistoryRequest extends FormRequest
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
      'student_id' => 'required|integer',
      'subject_id' => 'required|integer',
      'curriculum_id' => 'required|integer',
      'totalScore' => 'required',
      'isEquivalence' => 'required|integer',
      'year' => 'required|integer',
      'period' =>'required|integer',
    ];
  }

  public function messages()
  {
    return [
      'student_id.required' => 'required|integer',
      'subject_id.required' => 'required|integer',
      'curriculum_id.required' => 'required|integer',
      'totalScore.required' => 'required|float',
      'isEquivalence.required' => 'required|integer',
      'year.required' => 'required|integer',
      'period.required' =>'required|integer',
    ];
  }
}
