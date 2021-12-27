<?php

namespace App\Http\Controllers\Api;

use App\Models\Rotation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RotationController extends Controller
{
    //
    public function store(Request $request)
    {

        $rotation = Rotation::create([
            'numero' => $request->numero,
            'fecha' => $request->fecha,
            'observaciones' => $request->observaciones,
        ]);

        return response()->json($rotation, 201);
    }

    public function show(Rotation $rotation)
    {
        return response()->json($rotation);
    }

    public function update(Request $request)
    {
        $rotation = Rotation::findOrFail($request->id);

        $rotation->update([
            'fecha' => $request->fecha,
            'observaciones' => $request->observaciones,
        ]);

        return response()->json($rotation, 200);
    }

    public function destroy(Rotation $rotation)
    {
        $rotation->delete();

        return response()->json([], 204);
    }
}
