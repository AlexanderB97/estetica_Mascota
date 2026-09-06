<?php

namespace App\Livewire\Categorias;

use App\Models\Categoria;
use Livewire\Component;
use Livewire\WithPagination;

class CategoriasIndex extends Component
{
    use WithPagination;

    public $nombre, $descripcion;
    public $categoriaId;
    public $modal = false;
    public $search = '';

    protected $rules = [
        'nombre'      => 'required|string|max:255',
        'descripcion' => 'nullable|string',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal()
    {
        $this->reset(['nombre', 'descripcion', 'categoriaId']);
        $this->modal = true;
    }

    public function editar($id)
    {
        $categoria = Categoria::findOrFail($id);
        $this->categoriaId  = $categoria->id;
        $this->nombre       = $categoria->nombre;
        $this->descripcion  = $categoria->descripcion;
        $this->modal        = true;
    }

    public function guardar()
    {
        $this->validate();

        Categoria::updateOrCreate(
            ['id' => $this->categoriaId],
            [
                'nombre'      => $this->nombre,
                'descripcion' => $this->descripcion,
            ]
        );

        $this->modal = false;
        $this->reset(['nombre', 'descripcion', 'categoriaId']);
        session()->flash('mensaje', 'Categoría guardada correctamente.');
    }

    public function eliminar($id)
    {
        Categoria::findOrFail($id)->delete();
        session()->flash('mensaje', 'Categoría eliminada.');
    }

    public function render()
    {
        $categorias = Categoria::where('nombre', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.categorias.categorias-index', compact('categorias'))
            ->layout('components.layouts.app');
    }
}
