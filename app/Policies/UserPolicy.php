<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function delete(User $currentUser, User $targetUser)
    {
        return $currentUser->hasPermission('manage-users') && $currentUser->id !== $targetUser->id;
    }

    public function manage(User $user)
    {
        return $user->hasPermission('manage-users');
    }

    public function validate(User $currentUser, User $targetUser)
    {
        return $currentUser->hasPermission('validate-status') && $currentUser->id !== $targetUser->id;
    }
}
