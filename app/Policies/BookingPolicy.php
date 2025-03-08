<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->role === 'admin';
    }

    public function view(User $user, Booking $booking)
    {
        return $user->id === $booking->user_id || $user->role === 'admin';
    }

    public function create(User $user)
    {
        return $user->role === 'client';
    }

    public function delete(User $user, Booking $booking)
    {
        return $user->id === $booking->user_id || $user->role === 'admin';
    }
}
