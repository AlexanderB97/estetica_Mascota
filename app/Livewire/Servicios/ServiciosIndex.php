<?php

namespace App\Livewire\Servicios;

use App\Models\Servicio;
use Livewire\Component;
use Livewire\WithPagination;

class ServiciosIndex extends Component
{
    use WithPagination;

    public $nombre, $descripcion, $precio, $duracion_minutos;
    public $servicioId;
    public $modal = false;
    public $search = '';

    protected $rules = [
        'nombre'           => 'required|string|max:255',
        'descripcion'      => 'nullable|string',
        'precio'           => 'required|numeric|min:0',
        'duracion_minutos' => 'required|integer|min:1',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal()
    {
        $this->reset(['nombre', 'descripcion', 'precio', 'duracion_minutos', 'servicioId']);
        $this->modal = true;
    }

    public function editar($id)
    {
        $servicio = Servicio::findOrFail($id);
        $this->servicioId        = $servicio->id;
        $this->nombre            = $servicio->nombre;
        $this->descripcion       = $servicio->descripcion;
        $this->precio            = $servicio->precio;
        $this->duracion_minutos  = $servicio->duracion_minutos;
        $this->modal             = true;
    }

    public function guardar()
{
    if ($this->servicioId) {
        $this->authorize('update', Servicio::findOrFail($this->servicioId));
    } else {
        $this->authorize('create', Servicio::class);
    }

    $this->validate();

    Servicio::updateOrCreate(
        ['id' => $this->servicioId],
        [
            'nombre'           => $this->nombre,
            'descripcion'      => $this->descripcion,
            'precio'           => $this->precio,
            'duracion_minutos' => $this->duracion_minutos,
        ]
    );

    $this->modal = false;
    $this->reset(['nombre', 'descripcion', 'precio', 'duracion_minutos', 'servicioId']);
    session()->flash('mensaje', 'Servicio guardado correctamente.');
}

public function eliminar($id)
{
    $servicio = Servicio::findOrFail($id);
    $this->authorize('delete', $servicio);
    $servicio->delete();
    session()->flash('mensaje', 'Servicio eliminado.');
}

    public function render()
    {
        $servicios = Servicio::where('nombre', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.servicios.servicios-index', compact('servicios'))
            ->layout('components.layouts.app');
    }
}
