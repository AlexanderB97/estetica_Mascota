<?php

namespace App\Livewire\Caja;

use App\Models\CierreCaja;
use App\Models\Venta;
use Livewire\Component;

class CajaIndex extends Component
{
    public $monto_inicial = 0;
    public $monto_final = 0;
    public $cajaAbierta = null;

    public function mount()
    {
        $this->cajaAbierta = CierreCaja::where('usuario_id', auth()->id())
            ->whereNull('cerrado_at')
            ->latest()
            ->first();
    }

    public function abrirCaja()
    {
        $this->validate([
            'monto_inicial' => 'required|numeric|min:0',
        ]);

        $this->cajaAbierta = CierreCaja::create([
            'usuario_id'    => auth()->id(),
            'monto_inicial' => $this->monto_inicial,
            'abierto_at'    => now(),
        ]);

        session()->flash('mensaje', 'Caja abierta correctamente.');
    }

    public function cerrarCaja()
    {
        $this->validate([
            'monto_final' => 'required|numeric|min:0',
        ]);

        $this->cajaAbierta->update([
            'monto_final' => $this->monto_final,
            'cerrado_at'  => now(),
        ]);

        session()->flash('mensaje', 'Caja cerrada correctamente.');
        $this->cajaAbierta = null;
        $this->monto_final = 0;
    }

    public function getVentasDelTurnoProperty()
    {
        if (!$this->cajaAbierta) return collect();

        return Venta::where('usuario_id', auth()->id())
            ->where('created_at', '>=', $this->cajaAbierta->abierto_at)
            ->get();
    }

    public function getTotalEfectivoProperty()
    {
        return $this->ventasDelTurno
            ->where('metodo_pago', 'efectivo')
            ->where('estado', 'completada')
            ->sum('total');
    }

    public function getTotalTarjetaProperty()
    {
        return $this->ventasDelTurno
            ->where('metodo_pago', 'tarjeta')
            ->where('estado', 'completada')
            ->sum('total');
    }

    public function getTotalTransferenciaProperty()
    {
        return $this->ventasDelTurno
            ->where('metodo_pago', 'transferencia')
            ->where('estado', 'completada')
            ->sum('total');
    }

    public function getTotalVentasProperty()
    {
        return $this->ventasDelTurno
            ->where('estado', 'completada')
            ->sum('total');
    }

    public function render()
    {
        $historial = CierreCaja::where('usuario_id', auth()->id())
            ->whereNotNull('cerrado_at')
            ->latest()
            ->take(10)
            ->get();

        return view('livewire.caja.caja-index', compact('historial'))
            ->layout('components.layouts.app');
    }
}