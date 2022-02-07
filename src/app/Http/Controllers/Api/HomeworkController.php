<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Homework;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    public function store(Request $request)
    {

        $homework = Homework::create([
            'student_id' => $request->student_id,
            'tarea' => $request->tarea,
            'observacion' => $request->observacion,
            'fecha_entrega' => $request->fecha_entrega,
            'calificacion' => $request->calificacion,
        ]);

        return response()->json($homework, 201);
    }
}
