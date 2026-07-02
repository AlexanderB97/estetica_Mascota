<?php

namespace App\Policies;

use App\Models\Mascota;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MascotaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Mascota $mascota): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Mascota $mascota): bool
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Mascota $mascota): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Mascota $mascota): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Mascota $mascota): bool
    {
        return false;
    }
}