<?php

namespace App\Policies;

use App\Models\Venta;
use App\Models\User;

class VentaPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Venta $model): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    public function update(User $user, Venta $model): bool
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    public function delete(User $user, Venta $model): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, Venta $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Venta $model): bool
    {
        return false;
    }
}