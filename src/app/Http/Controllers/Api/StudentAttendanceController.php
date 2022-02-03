<?php

namespace App\Http\Controllers\Api;

use App\Models\StudentAttendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentAttendanceController extends Controller
{
    public function store(Request $request)
    {
        $studentAttendances = $request->json()->all();
        $studentData = [];
        foreach ($studentAttendances as $attendance) {
            $student = StudentAttendance::create($attendance);
            array_push($studentData, $student);
        }
        return response()->json($studentData, 201);
    }
}
