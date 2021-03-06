<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RotationStoreRequest extends FormRequest
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
            'fecha' => 'required',
            'numero' => 'required',
            'observaciones' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'fecha.required' => 'El campo fecha es requerido',
            'numero.required' => 'El campo numero es requerido',
        ];
    }
}
