<?php

namespace App\Http\Controllers\Api;

use App\Models\Rotation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RotationResource;
use App\Http\Requests\RotationStoreRequest;

class RotationController extends Controller
{
    //

    public function index()
    {
        $rotations = Rotation::all();

        return response()->json($rotations, 200);
    }

    public function store(RotationStoreRequest $request)
    {
        $rotation = Rotation::create($request->validated());

        return response()->json(new RotationResource($rotation), 201);
    }

    public function show(Rotation $rotation)
    {
        return response()->json($rotation, 200);
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
