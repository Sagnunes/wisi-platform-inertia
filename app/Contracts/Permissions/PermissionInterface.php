<?php

namespace App\Contracts\Permissions;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface PermissionInterface
{
    public function all(): Collection;

    public function permissionsPaginated(int $perPage): LengthAwarePaginator;

    public function find(int $id): Permission;

    public function create(array $data): Permission;

    public function update(Permission $permission, array $data): Permission;

    public function delete(Permission $permission): bool;
}
