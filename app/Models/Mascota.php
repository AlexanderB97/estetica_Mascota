<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    protected $fillable = [
        'cliente_id', 'nombre', 'especie', 'raza', 'fecha_nacimiento'
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }
}