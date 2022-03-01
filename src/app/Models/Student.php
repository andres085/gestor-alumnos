<?php

namespace App\Models;

use App\Models\Group;
use App\Models\Homework;
use App\Models\Rotation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'rotation_id',
        'group_id',
        'apellido',
        'nombre',
        'dni',
        'telefono',
        'email',
        'direccion'
    ];

    public function rotation()
    {
        return $this->belongsTo(Rotation::class);
    }

    public function homeworks()
    {
        return $this->hasMany(Homework::class);
    }

    public function attendance()
    {
        return $this->belongsToMany(Attendance::class, 'student_attendances')->withPivot('presente', 'ausente');
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
