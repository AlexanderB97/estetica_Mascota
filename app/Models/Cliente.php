<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'email',
        'direccion'
    ];

    public function mascotas()
    {
        return $this->hasMany(Mascota::class);
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }
}
