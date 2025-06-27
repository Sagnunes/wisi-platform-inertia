<?php

namespace App\Contracts\Permissions;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

interface PermissionInterface
{
    public function all(): Collection;

    public function find(int $id): Permission;

    public function create(array $data): Permission;

    public function update(Permission $permission, array $data): Permission;

    public function delete(Permission $permission): bool;
}
