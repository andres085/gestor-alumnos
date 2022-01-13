<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use App\Models\Rotation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;

class RotationStudentController extends Controller
{

    public function index($id)
    {
        $rotation = Rotation::find($id);

        $students = $rotation->students()->get();

        return response()->json(StudentResource::collection($students), 200);
    }
}
