<?php

namespace App\Livewire\Historial;

use App\Models\HistorialMascota;
use App\Models\Mascota;
use Livewire\Component;
use Livewire\WithPagination;

class HistorialIndex extends Component
{
    use WithPagination;

    public $mascota_id, $turno_id, $observaciones;
    public $historialId;
    public $modal = false;
    public $search = '';

    protected $rules = [
        'mascota_id'    => 'required|exists:mascotas,id',
        'observaciones' => 'required|string',
        'turno_id'      => 'nullable|exists:turnos,id',
    ];

    public function updatingSearch() { $this->resetPage(); }

    public function abrirModal()
    {
        $this->reset(['mascota_id', 'turno_id', 'observaciones', 'historialId']);
        $this->modal = true;
    }

    public function editar($id)
    {
        $historial = HistorialMascota::findOrFail($id);
        $this->historialId    = $historial->id;
        $this->mascota_id     = $historial->mascota_id;
        $this->turno_id       = $historial->turno_id;
        $this->observaciones  = $historial->observaciones;
        $this->modal          = true;
    }

    public function guardar()
    {
        $this->validate();

        HistorialMascota::updateOrCreate(
            ['id' => $this->historialId],
            [
                'mascota_id'    => $this->mascota_id,
                'turno_id'      => $this->turno_id,
                'observaciones' => $this->observaciones,
            ]
        );

        $this->modal = false;
        $this->reset(['mascota_id', 'turno_id', 'observaciones', 'historialId']);
        session()->flash('mensaje', 'Historial guardado correctamente.');
    }

    public function eliminar($id)
    {
        HistorialMascota::findOrFail($id)->delete();
        session()->flash('mensaje', 'Registro eliminado.');
    }

    public function render()
    {
        $historiales = HistorialMascota::with(['mascota', 'turno'])
            ->whereHas('mascota', function($q) {
                $q->where('nombre', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        $mascotas = Mascota::orderBy('nombre')->get();
        $turnos   = \App\Models\Turno::orderBy('fecha_hora', 'desc')->get();

        return view('livewire.historial.historial-index', compact('historiales', 'mascotas', 'turnos'))
            ->layout('components.layouts.app');
    }
}