<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialMascota extends Model
{
    protected $fillable = [
        'mascota_id',
        'turno_id',
        'observaciones'
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }

    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }
}
