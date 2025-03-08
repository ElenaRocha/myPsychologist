<?php

namespace App\Policies;

use App\Models\Pass;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PassPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->role === 'admin';
    }

    public function view(User $user, Pass $pass)
    {
        return $user->id === $pass->user_id || $user->role === 'admin';
    }

    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Pass $pass)
    {
        return $user->role === 'admin';
    }
}
