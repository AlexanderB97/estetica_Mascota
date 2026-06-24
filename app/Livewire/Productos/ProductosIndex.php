<?php

namespace App\Livewire\Productos;

use App\Models\Producto;
use Livewire\Component;
use Livewire\WithPagination;

class ProductosIndex extends Component
{
    use WithPagination;

    public $nombre, $descripcion, $precio, $stock, $categoria;
    public $productoId;
    public $modal = false;
    public $search = '';

    protected $rules = [
        'nombre'      => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'precio'      => 'required|numeric|min:0',
        'stock'       => 'required|integer|min:0',
        'categoria'   => 'required|string|max:255',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal()
    {
        $this->reset(['nombre', 'descripcion', 'precio', 'stock', 'categoria', 'productoId']);
        $this->modal = true;
    }

    public function editar($id)
    {
        $producto = Producto::findOrFail($id);
        $this->productoId  = $producto->id;
        $this->nombre      = $producto->nombre;
        $this->descripcion = $producto->descripcion;
        $this->precio      = $producto->precio;
        $this->stock       = $producto->stock;
        $this->categoria   = $producto->categoria;
        $this->modal       = true;
    }

    public function guardar()
    {
        $this->validate();

        Producto::updateOrCreate(
            ['id' => $this->productoId],
            [
                'nombre'      => $this->nombre,
                'descripcion' => $this->descripcion,
                'precio'      => $this->precio,
                'stock'       => $this->stock,
                'categoria'   => $this->categoria,
            ]
        );

        $this->modal = false;
        $this->reset(['nombre', 'descripcion', 'precio', 'stock', 'categoria', 'productoId']);
        session()->flash('mensaje', 'Producto guardado correctamente.');
    }

    public function eliminar($id)
    {
        Producto::findOrFail($id)->delete();
        session()->flash('mensaje', 'Producto eliminado.');
    }

    public function render()
    {
        $productos = Producto::where('nombre', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.productos.productos-index', compact('productos'))
            ->layout('components.layouts.app');
    }
}
