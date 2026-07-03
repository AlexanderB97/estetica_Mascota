<?php

namespace App\Livewire\Mascotas;

use App\Models\Cliente;
use App\Models\Mascota;
use Livewire\Component;
use Livewire\WithPagination;

class MascotasIndex extends Component
{
    use WithPagination;

    public $nombre;

    public $especie;

    public $raza;

    public $fecha_nacimiento;

    public $cliente_id;

    public $mascotaId;

    public $modal = false;

    public $search = '';

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'especie' => 'required|string|max:255',
        'raza' => 'nullable|string|max:255',
        'fecha_nacimiento' => 'nullable|date',
        'cliente_id' => 'required|exists:clientes,id',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal()
    {
        $this->reset(['nombre', 'especie', 'raza', 'fecha_nacimiento', 'cliente_id', 'mascotaId']);
        $this->modal = true;
    }

    public function editar($id)
    {
        $mascota = Mascota::findOrFail($id);
        $this->mascotaId = $mascota->id;
        $this->nombre = $mascota->nombre;
        $this->especie = $mascota->especie;
        $this->raza = $mascota->raza;
        $this->fecha_nacimiento = $mascota->fecha_nacimiento;
        $this->cliente_id = $mascota->cliente_id;
        $this->modal = true;
    }

    public function guardar()
    {
        $this->validate();

        if ($this->mascotaId) {
            $this->authorize('update', Mascota::findOrFail($this->mascotaId));
        } else {
            $this->authorize('create', Mascota::class);
        }

        Mascota::updateOrCreate(
            ['id' => $this->mascotaId],
            [
                'nombre'           => $this->nombre,
                'especie'          => $this->especie,
                'raza'             => $this->raza,
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'cliente_id'       => $this->cliente_id,
            ]
        );

        $this->modal = false;
        $this->reset(['nombre', 'especie', 'raza', 'fecha_nacimiento', 'cliente_id', 'mascotaId']);
        session()->flash('mensaje', 'Mascota guardada correctamente.');
    }

    public function eliminar($id)
    {
        $mascota = Mascota::findOrFail($id);
        $this->authorize('delete', $mascota);
        $mascota->delete();
        session()->flash('mensaje', 'Mascota eliminada.');
    }

    public function render()
    {
        $mascotas = Mascota::with('cliente')
            ->where('nombre', 'like', '%' . $this->search . '%')
            ->paginate(10);

        $clientes = Cliente::orderBy('nombre')->get();

        return view('livewire.mascotas.mascotas-index', compact('mascotas', 'clientes'))
            ->layout('components.layouts.app');
    }
}