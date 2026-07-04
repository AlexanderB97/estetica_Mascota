<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'categoria',
        'categoria_id'
    ];

    public function ventaItems()
    {
        return $this->hasMany(VentaItem::class);
    }

    public function compraItems()
    {
        return $this->hasMany(CompraItem::class);
    }

    public function movimientos()
    {
        return $this->hasMany(MovimientoStock::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
