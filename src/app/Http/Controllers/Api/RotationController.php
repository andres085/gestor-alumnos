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
}
