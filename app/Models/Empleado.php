<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable = [
        'user_id',
        'legajo',
        'dni',
        'telefono',
        'direccion',
        'fecha_ingreso',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_ingreso' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function turnosLaborales()
    {
        return $this->hasMany(TurnoLaboral::class);
    }
}
