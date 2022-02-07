<?php

namespace App\Http\Controllers\Api;

use App\Models\Homework;
use App\Http\Controllers\Controller;
use App\Http\Requests\HomeworkStoreRequest;

class HomeworkController extends Controller
{
    public function store(HomeworkStoreRequest $request)
    {

        $homework = Homework::create($request->validated());

        return response()->json($homework, 201);
    }
}
