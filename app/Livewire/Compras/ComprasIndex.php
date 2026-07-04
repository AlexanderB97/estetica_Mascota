<?php

namespace App\Livewire\Compras;

use App\Models\Compra;
use App\Models\CompraItem;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\MovimientoStock;
use Livewire\Component;
use Livewire\WithPagination;

class ComprasIndex extends Component
{
    use WithPagination;

    public $proveedor_id, $estado = 'pendiente';
    public $compraId;
    public $modal = false;
    public $modalDetalle = false;
    public $compraDetalle = null;
    public $search = '';

    public function mount()
{
    $this->authorize('admin');
}

    public $items = [];
    public $producto_id, $cantidad = 1, $precio = 0;

    protected $rules = [
        'proveedor_id' => 'required|exists:proveedores,id',
        'estado'       => 'required|in:pendiente,completada,cancelada',
        'items'        => 'required|array|min:1',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal()
    {
        $this->reset(['compraId', 'proveedor_id', 'estado', 'items', 'producto_id', 'cantidad', 'precio']);
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
                'precio'      => $this->precio,
                'cantidad'    => $this->cantidad,
            ];
        }

        $this->reset(['producto_id', 'cantidad', 'precio']);
        $this->cantidad = 1;
        $this->precio = 0;
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
        $this->validate();

        $compra = Compra::create([
            'proveedor_id' => $this->proveedor_id,
            'usuario_id'   => auth()->id(),
            'estado'       => $this->estado,
            'total'        => $this->total,
        ]);

        foreach ($this->items as $item) {
            $compra->items()->create([
                'producto_id' => $item['producto_id'],
                'cantidad'    => $item['cantidad'],
                'precio'      => $item['precio'],
            ]);

            if ($this->estado === 'completada') {
                $producto = Producto::find($item['producto_id']);
                $producto->increment('stock', $item['cantidad']);

                MovimientoStock::create([
                    'producto_id' => $item['producto_id'],
                    'usuario_id'  => auth()->id(),
                    'tipo'        => 'entrada',
                    'cantidad'    => $item['cantidad'],
                    'motivo'      => 'Compra #' . $compra->id,
                ]);
            }
        }

        $this->modal = false;
        session()->flash('mensaje', 'Compra registrada correctamente.');
    }

    public function verDetalle($id)
    {
        $this->compraDetalle = Compra::with(['items.producto', 'proveedor', 'usuario'])->findOrFail($id);
        $this->modalDetalle = true;
    }

    public function render()
    {
        $compras = Compra::with(['proveedor', 'usuario'])
            ->latest()
            ->paginate(10);

        $productos  = Producto::orderBy('nombre')->get();
        $proveedores = Proveedor::orderBy('nombre')->get();

        return view('livewire.compras.compras-index', compact('compras', 'productos', 'proveedores'))
            ->layout('components.layouts.app');
    }
}
