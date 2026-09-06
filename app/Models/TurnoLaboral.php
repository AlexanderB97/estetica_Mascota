<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TurnoLaboral extends Model
{
    protected $fillable = [
        'empleado_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
