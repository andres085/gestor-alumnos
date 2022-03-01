<?php

namespace App\Models;

use App\Models\Student;
use App\Models\StudentAttendance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'tema',
        'fecha',
    ];

    public function students()
    {
        return $this->hasManyThrough(Student::class, StudentAttendance::class, 'attendance_id', 'id', 'id', 'id');
    }
}
