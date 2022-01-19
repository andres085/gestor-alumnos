<?php

namespace App\Http\Controllers\Api;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceStoreRequest;

class AttendanceController extends Controller
{

    public function index()
    {
        $attendances = Attendance::all();

        return response()->json($attendances, 200);
    }

    public function store(AttendanceStoreRequest $request)
    {

        $attendance = Attendance::create($request->validate());

        return response()->json($attendance, 201);
    }

    public function show(Attendance $attendance)
    {
        return response()->json($attendance, 200);
    }

    public function update(Request $request)
    {
        $attendance = Attendance::findOrFail($request->id);

        $attendance->update([
            'tema' => $request->tema,
            'fecha' => $request->fecha,
        ]);

        return response()->json($attendance, 200);
    }

    public function destroy(Attendance $attendance)
    {
        $attendance = Attendance::findOrFail($attendance->id);

        $attendance->delete();

        return response()->json([], 204);
    }
}
