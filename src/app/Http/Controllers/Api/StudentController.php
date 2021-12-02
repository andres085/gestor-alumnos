<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;

class StudentController extends Controller
{
    //
    public function store(Request $request)
    {
        $student = Student::create([
            'apellido' => $request->apellido,
            'nombre' => $request->nombre,
            'dni' => $request->dni,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccion' => $request->direccion
        ]);

        return response()->json(new StudentResource($student), 201);
    }

    public function show($id)
    {

        $student = Student::findOrFail($id);

        return response()->json(new StudentResource($student));

    }

    public function update($id)
    {

        $student = Student::findOrFail($id);

        return response()->json(new StudentResource($student));

    }
}
