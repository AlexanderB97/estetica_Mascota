<?php

namespace App\Livewire\Stock;

use App\Models\MovimientoStock;
use App\Models\Producto;
use Livewire\Component;
use Livewire\WithPagination;

class StockIndex extends Component
{
    use WithPagination;

    public $producto_id, $tipo = 'ajuste', $cantidad, $motivo;
    public $modal = false;
    public $search = '';

    public function mount()
{
    $this->authorize('admin');
}

    protected $rules = [
        'producto_id' => 'required|exists:productos,id',
        'tipo'        => 'required|in:entrada,salida,ajuste',
        'cantidad'    => 'required|integer|min:1',
        'motivo'      => 'nullable|string|max:255',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal()
    {
        $this->reset(['producto_id', 'tipo', 'cantidad', 'motivo']);
        $this->tipo = 'ajuste';
        $this->modal = true;
    }

    public function guardar()
    {
        $this->validate();

        $producto = Producto::findOrFail($this->producto_id);

        if ($this->tipo === 'entrada') {
            $producto->increment('stock', $this->cantidad);
        } elseif ($this->tipo === 'salida') {
            if ($producto->stock < $this->cantidad) {
                $this->addError('cantidad', 'No hay suficiente stock disponible.');
                return;
            }
            $producto->decrement('stock', $this->cantidad);
        } else {
            $producto->update(['stock' => $this->cantidad]);
        }

        MovimientoStock::create([
            'producto_id' => $this->producto_id,
            'usuario_id'  => auth()->id(),
            'tipo'        => $this->tipo,
            'cantidad'    => $this->cantidad,
            'motivo'      => $this->motivo,
        ]);

        $this->modal = false;
        $this->reset(['producto_id', 'tipo', 'cantidad', 'motivo']);
        session()->flash('mensaje', 'Movimiento de stock registrado correctamente.');
    }

    public function render()
    {
        $movimientos = MovimientoStock::with(['producto', 'usuario'])
            ->whereHas('producto', function ($q) {
                $q->where('nombre', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        $productos = Producto::orderBy('nombre')->get();

        return view('livewire.stock.stock-index', compact('movimientos', 'productos'))
            ->layout('components.layouts.app');
    }
}
