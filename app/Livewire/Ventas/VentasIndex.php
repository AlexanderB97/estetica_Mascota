<?php

namespace App\Livewire\Ventas;

use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class VentasIndex extends Component
{
    use WithPagination;

    public $usuario_id;

    public $estado = 'pendiente';

    public $ventaId;

    public $modal = false;

    public $modalDetalle = false;

    public $ventaDetalle = null;

    public $search = '';

    public $items = [];

    public $producto_id;

    public $cantidad = 1;

    protected $rules = [
        'estado' => 'required|in:pendiente,completada,cancelada',
        'items' => 'required|array|min:1',
        'items.*.producto_id' => 'required|exists:productos,id',
        'items.*.cantidad' => 'required|integer|min:1',
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
        if (! $this->producto_id) {
            return;
        }
        $producto = Producto::find($this->producto_id);
        if (! $producto) {
            return;
        }

        $existe = false;
        foreach ($this->items as &$item) {
            if ($item['producto_id'] == $this->producto_id) {
                $item['cantidad'] += $this->cantidad;
                $existe = true;
                break;
            }
        }

        if (! $existe) {
            $this->items[] = [
                'producto_id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => $this->cantidad,
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
        return collect($this->items)->sum(fn ($i) => $i['precio'] * $i['cantidad']);
    }

    public function guardar()
    {
        $this->validate();

        DB::transaction(function () {
            $venta = Venta::updateOrCreate(
                ['id' => $this->ventaId],
                [
                    'usuario_id' => auth()->id(),
                    'estado' => $this->estado,
                    'total' => $this->total,
                ]
            );

            $venta->items()->delete();
            foreach ($this->items as $item) {
                $venta->items()->create([
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                ]);
            }
        });

        $this->modal = false;
        session()->flash('mensaje', 'Venta guardada correctamente.');
    }

    public function verDetalle($id)
    {
        $this->ventaDetalle = Venta::with(['items.producto', 'usuario'])->findOrFail($id);
        $this->modalDetalle = true;
    }

    public function eliminar($id)
    {
        Venta::findOrFail($id)->delete();
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
