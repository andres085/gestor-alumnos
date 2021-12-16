<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Http\Requests\StudentStoreRequest;

class StudentController extends Controller
{
    //
    public function store(StudentStoreRequest $request)
    {   

        $student = Student::create($request->validated());

        return response()->json(new StudentResource($student), 201);
        
    }

    public function show(Student $student)
    {
        dd($student);
        
        return response()->json(new StudentResource($student));

    }

    public function update(StudentStoreRequest $request, Student $student)
    {

        $student->update($request->validated());

        return response()->json(new StudentResource($student));

    }

    public function destroy(Student $student)
    {

        $student->delete();

        return response()->json([], 204);
    }
}
