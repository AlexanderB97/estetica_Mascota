<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $fillable = [
        'mascota_id',
        'servicio_id',
        'usuario_id',
        'cliente_id',
        'fecha_hora',
        'estado',
        'notas'
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function historial()
    {
        return $this->hasOne(HistorialMascota::class);
    }
}
