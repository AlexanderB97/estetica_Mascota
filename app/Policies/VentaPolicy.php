<?php

namespace App\Policies;

use App\Models\Venta;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class VentaPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Venta $venta): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    public function update(User $user, Venta $venta): bool
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    public function delete(User $user, Venta $venta): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, Venta $venta): bool
    {
        return false;
    }

    public function forceDelete(User $user, Venta $venta): bool
    {
        return false;
    }
}