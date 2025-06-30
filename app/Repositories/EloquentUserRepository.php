<?php

namespace App\Repositories;

use App\Contracts\Users\UserInterface;
use App\DTOs\Status\StatusDTO;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class EloquentUserRepository implements UserInterface
{
    protected User $model;

    private const USER_LIST_COLUMNS = ['id', 'name', 'email', 'status_id', 'created_at'];

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function baseQuery(): Builder
    {
        return $this->model->query()->select(self::USER_LIST_COLUMNS)->orderBy('name');
    }

    public function find(int $userId): User
    {
        return $this->baseQuery()->findOrFail($userId);
    }

    public function paginateWithRelations(int $perPage = 10)
    {
        $currentUser = Auth::user();

        return $this->baseQuery()
            ->with('status:id,name')
            ->with(['roles' => fn ($query) => $query->select(
                'roles.id',
                'roles.name',
                'role_user.user_id'
            )])
            ->paginate($perPage)
            ->through(function ($user) use ($currentUser) {
                return array_merge($user->toArray(), [
                    'can' => [
                        'delete' => $currentUser ? $currentUser->can('delete', $user) : false,
                        'validate' => $currentUser ? $currentUser->can('validate', $user) : false,
                    ],
                ]);
            });
    }

    public function updateStatus(User $user, StatusDTO $status): bool
    {

        $user->update(['status_id' => $status->id]);

        return $user->save();
    }

    public function assignRoles(User $user, array $rolesIds): array
    {
        return $user->roles()->sync($rolesIds);
    }

    public function delete(User $user): ?bool
    {
        return $user->delete();
    }
}
