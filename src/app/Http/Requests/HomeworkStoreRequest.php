<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeworkStoreRequest extends FormRequest
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
            'student_id' => 'nullable',
            'rotation_id' => 'nullable',
            'tarea' => 'required | string',
            'observacion' => 'nullable | string',
            'fecha_entrega' => 'required',
            'calificacion' => 'nullable | integer',
        ];
    }

    public function messages()
    {
        return [
            'tarea.required' => 'El campo tarea es requerido',
            'tarea.string' => 'El campo tarea es de solo texto',
            'fecha_entrega.required' => 'El campo fecha entrega es requerido',
        ];
    }
}
