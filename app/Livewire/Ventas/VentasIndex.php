<?php

namespace App\Livewire\Ventas;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\VentaItem;
use Livewire\Component;
use Livewire\WithPagination;

class VentasIndex extends Component
{
    use WithPagination;

    public $usuario_id, $estado = 'pendiente';
    public $ventaId;
    public $modal = false;
    public $modalDetalle = false;
    public $ventaDetalle = null;
    public $search = '';

    public $items = [];
    public $producto_id, $cantidad = 1;

    protected $rules = [
        'estado'     => 'required|in:pendiente,completada,cancelada',
        'items'      => 'required|array|min:1',
        'items.*.producto_id' => 'required|exists:productos,id',
        'items.*.cantidad'    => 'required|integer|min:1',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal()
    {
        $this->reset(['ventaId', 'estado', 'items', 'producto_id', 'cantidad']);
        $this->estado = 'pendiente';
        $this->items = [];
        $this->modal = true;
    }

    public function agregarItem()
    {
        if (!$this->producto_id) return;
        $producto = Producto::find($this->producto_id);
        if (!$producto) return;

        $existe = false;
        foreach ($this->items as &$item) {
            if ($item['producto_id'] == $this->producto_id) {
                $item['cantidad'] += $this->cantidad;
                $existe = true;
                break;
            }
        }

        if (!$existe) {
            $this->items[] = [
                'producto_id' => $producto->id,
                'nombre'      => $producto->nombre,
                'precio'      => $producto->precio,
                'cantidad'    => $this->cantidad,
            ];
        }

        $this->reset(['producto_id', 'cantidad']);
        $this->cantidad = 1;
    }

    public function quitarItem($index)
    {
        array_splice($this->items, $index, 1);
    }

    public function getTotalProperty()
    {
        return collect($this->items)->sum(fn($i) => $i['precio'] * $i['cantidad']);
    }

   public function guardar()
{
    if ($this->ventaId) {
        $this->authorize('update', Venta::findOrFail($this->ventaId));
    } else {
        $this->authorize('create', Venta::class);
    }

    $this->validate();

    \DB::transaction(function () {
        $venta = Venta::updateOrCreate(
            ['id' => $this->ventaId],
            [
                'usuario_id'  => auth()->id(),
                'cliente_id'  => $this->cliente_id ?? null,
                'estado'      => $this->estado,
                'metodo_pago' => $this->metodo_pago ?? 'efectivo',
                'total'       => $this->total,
            ]
        );

        $venta->items()->delete();

        foreach ($this->items as $item) {
            $producto = Producto::findOrFail($item['producto_id']);

            if ($producto->stock < $item['cantidad']) {
                throw new \Exception("Stock insuficiente para {$producto->nombre}");
            }

            $venta->items()->create([
                'producto_id'     => $item['producto_id'],
                'cantidad'        => $item['cantidad'],
                'precio_unitario' => $item['precio'],
                'subtotal'        => $item['precio'] * $item['cantidad'],
            ]);

            $producto->decrement('stock', $item['cantidad']);

            \App\Models\MovimientoStock::create([
                'producto_id' => $item['producto_id'],
                'usuario_id'  => auth()->id(),
                'tipo'        => 'salida',
                'cantidad'    => $item['cantidad'],
                'motivo'      => 'Venta #' . $venta->id,
            ]);
        }
    });

    $this->modal = false;
    $this->reset(['items', 'producto_id', 'cantidad', 'ventaId']);
    session()->flash('mensaje', 'Venta guardada correctamente.');
}

public function eliminar($id)
{
    $venta = Venta::findOrFail($id);
    $this->authorize('delete', $venta);
    $venta->delete();
    session()->flash('mensaje', 'Venta eliminada.');
}

    public function render()
    {
        $ventas = Venta::with(['usuario', 'items'])
            ->latest()
            ->paginate(10);

        $productos = Producto::orderBy('nombre')->get();

        return view('livewire.ventas.ventas-index', compact('ventas', 'productos'))
            ->layout('components.layouts.app');
    }
}
