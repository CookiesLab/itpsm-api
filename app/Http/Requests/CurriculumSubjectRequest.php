<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurriculumSubjectRequest extends FormRequest
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
            'uv' => 'required|integer',
            'curriculum_id' => 'required',
            'subject_id' => 'required',
        ];
    }

    public function messages()
    {
      return [
          'uv.required' => 'El campo uv es obligatorio',
          'curriculum_id.required' => 'El campo curriculum es obligatorio',
          'subject_id.required' => 'El campo materia es obligatorio',
      ];
    }
}
