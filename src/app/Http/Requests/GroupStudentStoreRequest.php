<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupStudentStoreRequest extends FormRequest
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
            'numero' => 'required',
            'rotation_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'numero.required' => 'El campo número es requerido',
            'rotation_id.required' => 'El campo rotación es requerido',
        ];
    }
}
