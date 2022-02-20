<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Homework extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'tarea',
        'observacion',
        'fecha_entrega',
        'calificacion'
    ];

    public function student()
    {
        return $this->hasOne(Student::class);
    }
}
