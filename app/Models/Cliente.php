<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nombre', 'telefono', 'email', 'direccion',
    ];

    public function mascotas()
    {
        return $this->hasMany(Mascota::class);
    }
}