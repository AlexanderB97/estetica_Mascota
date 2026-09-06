<?php

namespace App\Livewire\Ventas;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\VentaItem;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class VentasIndex extends Component
{
    use WithPagination;

    public $usuario_id, $estado = 'pendiente';
    public $cliente_id = null, $metodo_pago = 'efectivo';
    public $ventaId;
    public $modal = false;
    public $modalDetalle = false;
    public $ventaDetalle = null;
    public $search = '';

    public $items = [];

    // Ahora un solo selector combinado: "producto-5" o "servicio-3"
    public $item_seleccionado, $cantidad = 1;

    protected $rules = [
        'estado'     => 'required|in:pendiente,completada,cancelada',
        'items'      => 'required|array|min:1',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal()
    {
        $this->reset(['ventaId', 'estado', 'items', 'item_seleccionado', 'cantidad']);
        $this->estado = 'pendiente';
        $this->items = [];
        $this->modal = true;
    }

    public function agregarItem()
    {
        if (!$this->item_seleccionado) return;

        // Separar "producto-5" -> tipo=producto, id=5
        [$tipo, $id] = explode('-', $this->item_seleccionado);

        if ($tipo === 'producto') {
            $modelo = Producto::find($id);
        } else {
            $modelo = Servicio::find($id);
        }
        if (!$modelo) return;

        $existe = false;
        foreach ($this->items as &$item) {
            if ($item['tipo'] === $tipo && $item['id'] == $id) {
                $item['cantidad'] += $this->cantidad;
                $existe = true;
                break;
            }
        }

        if (!$existe) {
            $this->items[] = [
                'tipo'     => $tipo, // 'producto' o 'servicio'
                'id'       => $modelo->id,
                'nombre'   => $modelo->nombre,
                'precio'   => $modelo->precio,
                'cantidad' => $this->cantidad,
            ];
        }

        $this->reset(['item_seleccionado', 'cantidad']);
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

        DB::transaction(function () {
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
                if ($item['tipo'] === 'producto') {
                    $producto = Producto::findOrFail($item['id']);

                    if ($producto->stock < $item['cantidad']) {
                        throw new \Exception("Stock insuficiente para {$producto->nombre}");
                    }

                    $venta->items()->create([
                        'producto_id'     => $producto->id,
                        'servicio_id'     => null,
                        'cantidad'        => $item['cantidad'],
                        'precio_unitario' => $item['precio'],
                        'subtotal'        => $item['precio'] * $item['cantidad'],
                    ]);

                    $producto->decrement('stock', $item['cantidad']);

                    \App\Models\MovimientoStock::create([
                        'producto_id' => $producto->id,
                        'usuario_id'  => auth()->id(),
                        'tipo'        => 'salida',
                        'cantidad'    => $item['cantidad'],
                        'motivo'      => 'Venta #' . $venta->id,
                    ]);
                } else {
                    // Servicio: no descuenta stock, no genera movimiento
                    $venta->items()->create([
                        'producto_id'     => null,
                        'servicio_id'     => $item['id'],
                        'cantidad'        => $item['cantidad'],
                        'precio_unitario' => $item['precio'],
                        'subtotal'        => $item['precio'] * $item['cantidad'],
                    ]);
                }
            }
        });

        $this->modal = false;
        $this->reset(['items', 'item_seleccionado', 'cantidad', 'ventaId']);
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
        $servicios = Servicio::orderBy('nombre')->get();
        $clientes = Cliente::orderBy('nombre')->get();

        return view('livewire.ventas.ventas-index', compact('ventas', 'productos', 'servicios', 'clientes'))
            ->layout('components.layouts.app');
    }
}