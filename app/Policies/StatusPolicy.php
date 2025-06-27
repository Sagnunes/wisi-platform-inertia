<?php

namespace App\Policies;

use App\Models\Status;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StatusPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasRole('Administrador') && $user->hasPermission('view-any-status') ? Response::allow() : Response::deny('You are not authorized');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Status $status): Response
    {
        return $user->hasRole('Administrador') && $user->hasPermission('view-status') ? Response::allow() : Response::deny('You are not authorized');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasRole('Administrador') && $user->hasPermission('create-status') ? Response::allow() : Response::deny('You are not authorized');
    }

    /**
     * Determine whether the user can edit the model.
     */
    public function edit(User $user): Response
    {
        return $user->hasRole('Administrador') && $user->hasPermission('edit-status') ? Response::allow() : Response::deny('You are not authorized');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Status $status): Response
    {
        return $user->hasRole('Administrador') && $user->hasPermission('update-status') ? Response::allow() : Response::deny('You are not authorized');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        return $user->hasRole('Administrador') && $user->hasPermission('delete-status') ? Response::allow() : Response::deny('You are not authorized');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Status $status): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Status $status): bool
    {
        return false;
    }
}
