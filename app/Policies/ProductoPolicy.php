<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\User;

class ProductoPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Producto $model): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    public function update(User $user, Producto $model): bool
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    public function delete(User $user, Producto $model): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, Producto $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Producto $model): bool
    {
        return false;
    }
}