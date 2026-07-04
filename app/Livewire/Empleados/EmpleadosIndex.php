<?php

namespace App\Livewire\Empleados;

use App\Models\Empleado;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class EmpleadosIndex extends Component
{
    use WithPagination;

    public $user_id, $legajo, $dni, $telefono, $direccion, $fecha_ingreso, $activo = true;
    public $name, $email, $password, $role = 'vendedor';
    public $empleadoId;
    public $modal = false;
    public $search = '';

     public function mount()
{
    $this->authorize('admin');
}

    protected $rules = [
        'name'         => 'required|string|max:255',
        'email'        => 'required|email|max:255',
        'role'         => 'required|in:admin,vendedor',
        'legajo'       => 'required|string|max:50',
        'dni'          => 'required|string|max:20',
        'telefono'     => 'nullable|string|max:20',
        'direccion'    => 'nullable|string|max:255',
        'fecha_ingreso' => 'required|date',
        'activo'       => 'boolean',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function abrirModal()
    {
        $this->reset(['user_id', 'legajo', 'dni', 'telefono', 'direccion', 'fecha_ingreso', 'name', 'email', 'password', 'empleadoId']);
        $this->activo = true;
        $this->role = 'vendedor';
        $this->modal = true;
    }

    public function editar($id)
    {
        $empleado = Empleado::with('user')->findOrFail($id);
        $this->empleadoId    = $empleado->id;
        $this->user_id       = $empleado->user_id;
        $this->name          = $empleado->user->name;
        $this->email         = $empleado->user->email;
        $this->role          = $empleado->user->role;
        $this->legajo        = $empleado->legajo;
        $this->dni           = $empleado->dni;
        $this->telefono      = $empleado->telefono;
        $this->direccion     = $empleado->direccion;
        $this->fecha_ingreso = $empleado->fecha_ingreso;
        $this->activo        = $empleado->activo;
        $this->modal         = true;
    }

    public function guardar()
    {
        $rules = $this->rules;
        if (!$this->empleadoId) {
            $rules['email'] = 'required|email|unique:users,email';
            $rules['password'] = 'required|string|min:8';
        }
        $this->validate($rules);

        if ($this->empleadoId) {
            $empleado = Empleado::findOrFail($this->empleadoId);
            $empleado->user->update([
                'name'  => $this->name,
                'email' => $this->email,
                'role'  => $this->role,
            ]);
            $empleado->update([
                'legajo'        => $this->legajo,
                'dni'           => $this->dni,
                'telefono'      => $this->telefono,
                'direccion'     => $this->direccion,
                'fecha_ingreso' => $this->fecha_ingreso,
                'activo'        => $this->activo,
            ]);
        } else {
            $user = User::create([
                'name'     => $this->name,
                'email'    => $this->email,
                'password' => bcrypt($this->password),
                'role'     => $this->role,
            ]);
            Empleado::create([
                'user_id'       => $user->id,
                'legajo'        => $this->legajo,
                'dni'           => $this->dni,
                'telefono'      => $this->telefono,
                'direccion'     => $this->direccion,
                'fecha_ingreso' => $this->fecha_ingreso,
                'activo'        => $this->activo,
            ]);
        }

        $this->modal = false;
        session()->flash('mensaje', 'Empleado guardado correctamente.');
    }

    public function toggleActivo($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->update(['activo' => !$empleado->activo]);
        session()->flash('mensaje', 'Estado del empleado actualizado.');
    }

    public function render()
    {
        $empleados = Empleado::with('user')
            ->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.empleados.empleados-index', compact('empleados'))
            ->layout('components.layouts.app');
    }
}
