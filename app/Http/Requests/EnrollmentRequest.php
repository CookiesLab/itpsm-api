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
            'final_score' => 'required|numeric',
            'is_approved' => 'required|boolean',
            'enrollment' => 'required|integer'
        ];
    }

    public function messages()
    {
      return [
          'final_score.required' => 'El campo final_score es obligatorio',
          'is_approved.required' => 'El campo is_approved es obligatorio',
          'enrollment.required' => 'El campo enrollment es obligatorio'
      ];
    }
}
