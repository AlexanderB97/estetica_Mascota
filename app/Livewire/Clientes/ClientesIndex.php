<?php

namespace App\Livewire\Clientes;

use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;

class ClientesIndex extends Component
{
    use WithPagination;

    public $nombre, $apellido, $telefono, $email, $direccion;
    public $clienteId;
    public $modal = false;
    public $search = '';

    protected $rules = [
        'nombre'    => 'required|string|max:255',
        'apellido'  => 'required|string|max:255',
        'telefono'  => 'nullable|string|max:20',
        'email'     => 'nullable|email|max:255',
        'direccion' => 'nullable|string|max:255',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal()
    {
        $this->reset(['nombre', 'apellido', 'telefono', 'email', 'direccion', 'clienteId']);
        $this->modal = true;
    }

    public function editar($id)
    {
        $cliente = Cliente::findOrFail($id);
        $this->clienteId  = $cliente->id;
        $this->nombre     = $cliente->nombre;
        $this->apellido   = $cliente->apellido;
        $this->telefono   = $cliente->telefono;
        $this->email      = $cliente->email;
        $this->direccion  = $cliente->direccion;
        $this->modal      = true;
    }

    public function guardar()
{
    if ($this->clienteId) {
        $this->authorize('update', Cliente::findOrFail($this->clienteId));
    } else {
        $this->authorize('create', Cliente::class);
    }

    $this->validate();

    Cliente::updateOrCreate(
        ['id' => $this->clienteId],
        [
            'nombre'    => $this->nombre,
            'apellido'  => $this->apellido,
            'telefono'  => $this->telefono,
            'email'     => $this->email,
            'direccion' => $this->direccion,
        ]
    );

    $this->modal = false;
    $this->reset(['nombre', 'apellido', 'telefono', 'email', 'direccion', 'clienteId']);
    session()->flash('mensaje', 'Cliente guardado correctamente.');
}

public function eliminar($id)
{
    $cliente = Cliente::findOrFail($id);
    $this->authorize('delete', $cliente);
    $cliente->delete();
    session()->flash('mensaje', 'Cliente eliminado.');
}

    public function render()
    {
        $clientes = Cliente::where('nombre', 'like', '%' . $this->search . '%')
            ->orWhere('apellido', 'like', '%' . $this->search . '%')
            ->orWhere('telefono', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.clientes.clientes-index', compact('clientes'))
            ->layout('components.layouts.app');
    }
}
