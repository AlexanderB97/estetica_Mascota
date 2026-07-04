<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoStock extends Model
{
    protected $fillable = [
        'producto_id',
        'usuario_id',
        'tipo',
        'cantidad',
        'motivo'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
