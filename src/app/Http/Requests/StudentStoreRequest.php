<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
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
            'rotation_id' => 'nullable',
            'apellido' => 'required',
            'nombre' => 'required',
            'dni' => 'required | integer',
            'telefono' => 'required',
            'email' => 'email',
            'direccion' => 'min:5 | max:30'
        ];
    }

    public function messages()
    {
        return [
            'apellido.required' => 'El campo apellido es requerido',
            'nombre.required' => 'El campo nombre es requerido',
            'dni.required' => 'El campo dni es requerido',
            'telefono.required' => 'El campo telefono es requerido',
            'email.email' => 'El campo email debe ser valido',
            'direccion.min' => 'El campo dirección no puede contener un minimo de 5 caracteres',
            'direccion.max' => 'El campo dirección no puede contener un maximo de 30 caracteres',
        ];
    }
}
