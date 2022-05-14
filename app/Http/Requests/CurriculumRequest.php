<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurriculumRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'year' => 'required|integer',
            'is_active' => 'required|boolean',
            'career_id' => 'required',
            'is_approved' => 'required|boolean',
        ];
    }

    public function messages()
  {
    return [
      'name.required' => 'El campo nombre es obligatorio',
      'year.required' => 'El campo año es obligatorio',
      'is_active.required' => 'El campo is_active es obligatorio',
      'career_id.required' => 'El campo career_id es obligatorio',
      'is_approved.required' => 'El campo is_approved es obligatorio'
    ];
  }
}
