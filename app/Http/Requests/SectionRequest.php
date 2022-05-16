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
            'schedule' => 'required|string|max:255',
            'teacher_id' => 'required',
        ];
    }

    public function messages()
    {
      return [
          'quota.required' => 'El campo quota es obligatorio',
          'schedule.required' => 'El campo schedule es obligatorio',
          'teacher_id.required' => 'El campo teacher_id es obligatorio'
      ];
    }
}
