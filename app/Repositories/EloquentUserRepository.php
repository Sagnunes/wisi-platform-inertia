<?php

namespace App\Repositories;

use App\Contracts\UserInterface;
use App\Models\Status;
use App\Models\User;

class EloquentUserRepository implements UserInterface
{
    public function paginateWithRelations(int $perPage = 10)
    {
        return User::select(['id', 'name', 'email', 'job_title', 'gov_department', 'status_id', 'created_at'])
            ->with('status:id,name')
            ->with(['roles' => fn ($query) => $query->select(
                'roles.id',
                'roles.name',
                'role_user.user_id'
            )])
            ->orderBy('name')
            ->paginate();
    }

    public function updateStatus(User $user, Status $status)
    {
        $user->status()->associate($status);
        $user->save();
    }

    public function assignRoles(User $user, array $rolesIds)
    {
        $user->roles()->sync($rolesIds);
    }
}
