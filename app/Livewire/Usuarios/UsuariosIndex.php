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

    protected function rules()
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $this->usuarioId,
            'password' => $this->usuarioId ? 'nullable|min:8' : 'required|min:8',
            'role'     => 'required|in:admin,vendedor',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal()
    {
        $this->reset(['name', 'email', 'password', 'usuarioId']);
        $this->role = 'vendedor';
        $this->modal = true;
    }

    public function editar($id)
    {
        $usuario = User::findOrFail($id);
        $this->usuarioId = $usuario->id;
        $this->name = $usuario->name;
        $this->email = $usuario->email;
        $this->role = $usuario->role;
        $this->password = '';
        $this->modal = true;
    }

    public function guardar()
    {
        $this->authorize('admin');
        $this->validate();

        $data = [
            'name'  => $this->name,
            'email' => $this->email,
            'role'  => $this->role,
        ];

        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        User::updateOrCreate(['id' => $this->usuarioId], $data);

        $this->modal = false;
        $this->reset(['name', 'email', 'password', 'usuarioId']);
        session()->flash('mensaje', 'Usuario guardado correctamente.');
    }

    public function eliminar($id)
    {
        $this->authorize('admin');

        if ($id == auth()->id()) {
            session()->flash('error', 'No podés eliminar tu propio usuario.');
            return;
        }

        User::findOrFail($id)->delete();
        session()->flash('mensaje', 'Usuario eliminado.');
    }

    public function render()
    {
        $usuarios = User::where('name', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.usuarios.usuarios-index')
            ->with('usuarios', $usuarios)
            ->layout('components.layouts.app');
    }
}