<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'fecha',
        'observaciones'
    ];

    public function getFormattedDateAttribute()
    {
        return $this->fecha->format('d/m/Y');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
