<?php

namespace App\Livewire\Usuarios;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsuariosIndex extends Component
{
    use WithPagination;

    public $name, $email, $password, $role = 'vendedor';
    public $usuarioId;
    public $modal = false;
    public $search = '';

     public function mount()
    {
        $this->authorize('admin');
    }

    protected $rules = [
        'name'  => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'role'  => 'required|in:admin,vendedor',
    ];

    public function updatingSearch() { $this->resetPage(); }

    public function abrirModal()
    {
        $this->reset(['name', 'email', 'password', 'role', 'usuarioId']);
        $this->role = 'vendedor';
        $this->modal = true;
    }

    public function editar($id)
    {
        $usuario = User::findOrFail($id);
        $this->usuarioId = $usuario->id;
        $this->name      = $usuario->name;
        $this->email     = $usuario->email;
        $this->role      = $usuario->role;
        $this->modal     = true;
    }

    public function guardar()
{
    $this->authorize('admin');

    $rules = $this->rules;
    if (!$this->usuarioId) {
        $rules['email']    = 'required|email|unique:users,email';
        $rules['password'] = 'required|string|min:8';
    }
    $this->validate($rules);

    // ... resto del método igual
}

public function eliminar($id)
{
    $this->authorize('admin');

    if ($id === auth()->id()) {
        session()->flash('error', 'No podés eliminar tu propio usuario.');
        return;
    }
    User::findOrFail($id)->delete();
    session()->flash('mensaje', 'Usuario eliminado.');
}

    public function render()
    {
        $usuarios = User::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.usuarios.usuarios-index', compact('usuarios'))
            ->layout('components.layouts.app');
    }
}