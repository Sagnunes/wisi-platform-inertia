<?php

namespace App\Repositories;

use App\Contracts\Permissions\PermissionInterface;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

class EloquentPermissionRepository implements PermissionInterface
{
    /**
     * The columns to select from the permission table
     */
    private const PERMISSION_LIST_COLUMNS = ['id', 'name', 'slug', 'created_at', 'updated_at'];

    public function all(): Collection
    {
        return Permission::query()->select(self::PERMISSION_LIST_COLUMNS)->orderBy('name')->get();
    }

    public function find(int $id): Permission
    {
        return Permission::query()->select(self::PERMISSION_LIST_COLUMNS)->findOrFail($id);
    }

    public function create(array $data): Permission
    {
        return Permission::query()->create($data);
    }

    public function update(Permission $permission, array $data): Permission
    {
        $permission->update($data);

        return $permission->fresh();
    }

    public function delete(Permission $permission): bool
    {
        return $permission->delete();
    }
}
