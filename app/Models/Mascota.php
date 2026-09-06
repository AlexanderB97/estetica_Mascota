<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    protected $fillable = [
        'cliente_id',
        'nombre',
        'especie',
        'raza',
        'fecha_nacimiento'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }

    public function historiales()
    {
        return $this->hasMany(HistorialMascota::class);
    }
}
