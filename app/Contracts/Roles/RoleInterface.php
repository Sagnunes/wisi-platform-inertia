<?php

namespace App\Contracts\Roles;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

interface RoleInterface
{
    public function all(): Collection;

    public function find(int $id): Role;

    public function create(array $data): Role;

    public function update(Role $role, array $data): Role;

    public function delete(Role $role): bool;
}
