<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = [
        'nombre', 'descripcion', 'precio', 'duracion_minutos'
    ];

    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }
}