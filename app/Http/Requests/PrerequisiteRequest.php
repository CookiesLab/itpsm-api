<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrerequisiteRequest extends FormRequest
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
            'prerequisite_id' => 'required',
            'curriculum_subject_id' => 'required'
        ];
    }

    public function messages()
    {
      return [
          'prerequisite_id.required' => 'El campo prerequisite_id es obligatorio',
          'curriculum_subject_id.required' => 'El campo curriculum_subject_id es obligatorio'
      ];
    }
}
