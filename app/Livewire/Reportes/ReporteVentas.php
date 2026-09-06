<?php

namespace App\Livewire\Reportes;

use App\Models\Venta;
use App\Models\User;
use Livewire\Component;

class ReporteVentas extends Component
{
    public $desde;
    public $hasta;
    public $usuario_id = '';

      public function mount()
{
    $this->authorize('admin');

    $this->desde = now()->startOfMonth()->format('Y-m-d');
    $this->hasta = now()->format('Y-m-d');
}

    public function render()
    {
        $query = Venta::with(['usuario', 'items'])
            ->whereBetween('created_at', [$this->desde . ' 00:00:00', $this->hasta . ' 23:59:59']);

        if ($this->usuario_id) {
            $query->where('usuario_id', $this->usuario_id);
        }

        $ventas = $query->get();

        $porEmpleado = $ventas->groupBy('usuario_id')->map(function($ventasEmpleado) {
            return [
                'nombre'        => $ventasEmpleado->first()->usuario->name,
                'cantidad'      => $ventasEmpleado->count(),
                'total'         => $ventasEmpleado->sum('total'),
                'completadas'   => $ventasEmpleado->where('estado', 'completada')->count(),
            ];
        })->sortByDesc('total');

        $usuarios = User::orderBy('name')->get();

        return view('livewire.reportes.reporte-ventas', compact('porEmpleado', 'ventas', 'usuarios'))
            ->layout('components.layouts.app');
    }
}