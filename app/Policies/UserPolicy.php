<?php

// app/Policies/UserPolicy.php
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can view any users.
     */
    public function viewAny(User $user)
    {
        return $user->hasPerfil('Admin');
    }

    /**
     * Determine if the given user can create a new user.
     */
    public function create(User $user)
    {
        return $user->hasPerfil('Admin');
    }

    /**
     * Determine if the given user can update another user.
     */
    public function update(User $user, User $model)
    {
        return $user->hasPerfil('Admin');
    }

    /**
     * Determine if the given user can delete another user.
     */
    public function delete(User $user, User $model)
    {
        return $user->hasPerfil('Admin');
    }
}
