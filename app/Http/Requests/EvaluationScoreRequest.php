<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EvaluationScoreRequest extends FormRequest
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
            'student_id' => 'required',
            'evaluation_id' => 'required',
            'score' => 'required|float',
        ];
    }

    public function messages()
    {
      return [
          'student_id.required' => 'El campo student_id es obligatorio',
          'evaluation_id.required' => 'El campo evaluation_id es obligatorio',
          'score.required' => 'El campo score es obligatorio',
      ];
    }
}
