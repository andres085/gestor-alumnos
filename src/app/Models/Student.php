<?php

namespace App\Models;

use App\Models\Rotation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'rotation_id',
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
}
