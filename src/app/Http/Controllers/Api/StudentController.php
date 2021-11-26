<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    //
    public function store()
    {
        $student = Student::create([
            'apellido' => request('apellido'),
            'nombre' => request('nombre'),
            'dni' => request('dni'),
            'telefono' => request('telefono'),
            'email' => request('email'),
            'direccion' => request('direccion')
        ]);

        return response()->json($student, 201);
    }
}
