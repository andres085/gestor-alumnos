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

    protected $casts = [
        'fecha' => 'datetime:d/m/Y',
    ];

    public function getFormattedDateAttribute()
    {
        return $this->fecha->format('d/m/Y');
    }

}
