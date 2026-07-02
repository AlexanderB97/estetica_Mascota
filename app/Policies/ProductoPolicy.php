<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductoPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Producto $producto): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    public function update(User $user, Producto $producto): bool
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    public function delete(User $user, Producto $producto): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, Producto $producto): bool
    {
        return false;
    }

    public function forceDelete(User $user, Producto $producto): bool
    {
        return false;
    }
}