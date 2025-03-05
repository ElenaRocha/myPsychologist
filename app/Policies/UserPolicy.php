<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can create users.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        // Solo los administradores pueden crear usuarios
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can update the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function update(User $user, User $model)
    {
        // Un usuario puede actualizar solo su propio perfil o ser admin
        return $user->id === $model->id || $user->role === 'admin';
    }

    /**
     * Determine if the user can delete the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function delete(User $user, User $model)
    {
        // Solo los administradores pueden eliminar usuarios
        return $user->role === 'admin';
    }
}
