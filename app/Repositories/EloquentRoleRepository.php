<?php

namespace App\Repositories;

use App\Contracts\Roles\RoleInterface;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentRoleRepository implements RoleInterface
{
    protected Role $model;

    /**
     * The columns to select from the role table
     */
    private const ROLE_LIST_COLUMNS = ['id', 'name', 'slug', 'description', 'created_at', 'updated_at'];

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    private function baseQuery(): Builder
    {
        return $this->model->query()->select(self::ROLE_LIST_COLUMNS)->orderBy('name');
    }

    public function all(): Collection
    {
        return $this->baseQuery()->get();
    }

    public function rolesPaginated(int $perPage): LengthAwarePaginator
    {
        return $this->baseQuery()->paginate($perPage)->withQueryString();
    }

    public function find(int $id): Role
    {
        return $this->baseQuery()->findOrFail($id);
    }

    public function create(array $data): Role
    {
        return $this->model->create($data);
    }

    public function update(Role $role, array $data): Role
    {
        $role->update($data);

        return $role->fresh();
    }

    public function delete(Role $role): bool
    {
        return $role->delete();
    }

    public function findOneWithPermissions($roleID): Role
    {
        return Role::query()
            ->select(self::ROLE_LIST_COLUMNS)
            ->with('permissions')
            ->where('id', $roleID)
            ->firstOrFail();
    }
}
