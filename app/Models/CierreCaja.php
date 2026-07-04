<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CierreCaja extends Model
{
    protected $fillable = [
        'usuario_id',
        'monto_inicial',
        'monto_final',
        'abierto_at',
        'cerrado_at'
    ];

    protected $casts = [
        'abierto_at' => 'datetime',
        'cerrado_at' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
