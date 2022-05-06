<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeriodRequest extends FormRequest
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
            'code' => 'required|integer',
            'year' => 'required|integer',
        ];
    }

    public function messages()
    {
      return [
          'code.required' => 'El campo code es obligatorio',
          'year.required' => 'El campo year es obligatorio',
      ];
    }
}
