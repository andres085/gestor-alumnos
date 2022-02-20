<?php

namespace App\Http\Controllers\Api;

use App\Models\Homework;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\HomeworkStoreRequest;

class HomeworkController extends Controller
{

    public function index(Request $request)
    {
        if (!$request->student_id) {
            return response()->json([], 406);
        }

        $homeworks = Homework::where('student_id', $request->student_id)->get();

        if (count($homeworks) === 0) {
            return response()->json([], 404);
        }

        return response()->json($homeworks, 200);
    }

    public function store(HomeworkStoreRequest $request)
    {

        $homework = Homework::create($request->validated());

        return response()->json($homework, 201);
    }

    public function show(Homework $homework)
    {
        $homework = Homework::findOrFail($homework->id);

        return response()->json($homework, 200);
    }

    public function update(Homework $homework)
    {
        $homework = Homework::findOrFail($homework->id);

        $homework->update([
            'tarea' => $homework->tarea,
            'observacion' => $homework->observacion,
            'fecha_entrega' => $homework->fecha_entrega,
            'calificacion' => $homework->calificacion
        ]);

        return response()->json($homework, 200);
    }

    public function destroy(Homework $homework)
    {
        $homework->delete();

        return response()->json([], 204);
    }
}
