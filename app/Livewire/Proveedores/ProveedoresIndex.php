<?php

namespace App\Livewire\Proveedores;

use App\Models\Proveedor;
use Livewire\Component;
use Livewire\WithPagination;

class ProveedoresIndex extends Component
{
    use WithPagination;

    public $nombre, $telefono, $email, $direccion;
    public $proveedorId;
    public $modal = false;
    public $search = '';

    public function mount()
{
    $this->authorize('admin');
}

    protected $rules = [
        'nombre'    => 'required|string|max:255',
        'telefono'  => 'nullable|string|max:20',
        'email'     => 'nullable|email|max:255',
        'direccion' => 'nullable|string|max:255',
    ];

    public function updatingSearch() { $this->resetPage(); }

    public function abrirModal()
    {
        $this->reset(['nombre', 'telefono', 'email', 'direccion', 'proveedorId']);
        $this->modal = true;
    }

    public function editar($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $this->proveedorId = $proveedor->id;
        $this->nombre      = $proveedor->nombre;
        $this->telefono    = $proveedor->telefono;
        $this->email       = $proveedor->email;
        $this->direccion   = $proveedor->direccion;
        $this->modal       = true;
    }

    public function guardar()
    {
        $this->validate();

        Proveedor::updateOrCreate(
            ['id' => $this->proveedorId],
            [
                'nombre'    => $this->nombre,
                'telefono'  => $this->telefono,
                'email'     => $this->email,
                'direccion' => $this->direccion,
            ]
        );

        $this->modal = false;
        $this->reset(['nombre', 'telefono', 'email', 'direccion', 'proveedorId']);
        session()->flash('mensaje', 'Proveedor guardado correctamente.');
    }

    public function eliminar($id)
    {
        Proveedor::findOrFail($id)->delete();
        session()->flash('mensaje', 'Proveedor eliminado.');
    }

    public function render()
    {
        $proveedores = Proveedor::where('nombre', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.proveedores.proveedores-index', compact('proveedores'))
            ->layout('components.layouts.app');
    }
}