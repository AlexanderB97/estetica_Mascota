<?php

namespace App\Livewire\Turnos;

use App\Models\Mascota;
use App\Models\Servicio;
use App\Models\Turno;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class TurnosIndex extends Component
{
    use WithPagination;

    public $mascota_id;

    public $servicio_id;

    public $usuario_id;

    public $fecha_hora;

    public $estado;

    public $notas;

    public $turnoId;

    public $modal = false;

    public $search = '';

    protected $rules = [
        'mascota_id' => 'required|exists:mascotas,id',
        'servicio_id' => 'required|exists:servicios,id',
        'usuario_id' => 'required|exists:users,id',
        'fecha_hora' => 'required|date',
        'estado' => 'required|in:pendiente,confirmado,cancelado,completado',
        'notas' => 'nullable|string',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal()
    {
        $this->reset(['mascota_id', 'servicio_id', 'usuario_id', 'fecha_hora', 'estado', 'notas', 'turnoId']);
        $this->estado = 'pendiente';
        $this->modal = true;
    }

    public function editar($id)
    {
        $turno = Turno::findOrFail($id);
        $this->turnoId = $turno->id;
        $this->mascota_id = $turno->mascota_id;
        $this->servicio_id = $turno->servicio_id;
        $this->usuario_id = $turno->usuario_id;
        $this->fecha_hora = $turno->fecha_hora;
        $this->estado = $turno->estado;
        $this->notas = $turno->notas;
        $this->modal = true;
    }

    public function guardar()
    {
        $this->validate();

        Turno::updateOrCreate(
            ['id' => $this->turnoId],
            [
                'mascota_id' => $this->mascota_id,
                'servicio_id' => $this->servicio_id,
                'usuario_id' => $this->usuario_id,
                'fecha_hora' => $this->fecha_hora,
                'estado' => $this->estado,
                'notas' => $this->notas,
            ]
        );

        $this->modal = false;
        $this->reset(['mascota_id', 'servicio_id', 'usuario_id', 'fecha_hora', 'estado', 'notas', 'turnoId']);
        session()->flash('mensaje', 'Turno guardado correctamente.');
    }

    public function eliminar($id)
    {
        Turno::findOrFail($id)->delete();
        session()->flash('mensaje', 'Turno eliminado.');
    }

    public function render()
    {
        $turnos = Turno::with(['mascota', 'servicio', 'usuario'])
            ->whereHas('mascota', function ($q) {
                $q->where('nombre', 'like', '%'.$this->search.'%');
            })
            ->orWhereHas('servicio', function ($q) {
                $q->where('nombre', 'like', '%'.$this->search.'%');
            })
            ->paginate(10);

        $mascotas = Mascota::orderBy('nombre')->get();
        $servicios = Servicio::orderBy('nombre')->get();
        $usuarios = User::orderBy('name')->get();

        return view('livewire.turnos.turnos-index', compact('turnos', 'mascotas', 'servicios', 'usuarios'))
            ->layout('components.layouts.app');
    }
}
