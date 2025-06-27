<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Permissions\PermissionInterface;
use App\Contracts\Roles\RoleInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class RolePermissionService
{
    public function __construct(
        private readonly RoleInterface $roleRepository,
        private readonly PermissionInterface $permissionRepository,
    ) {}

    public function allPermissions(): Collection
    {
        return $this->permissionRepository->all();
    }

    public function roleWithPermissions($roleId): Collection
    {
        return $this->roleRepository->findOneWithPermissions($roleId);
    }

    public function syncPermissionToRole(int $roleId, array $permissionIds): void
    {
        $role = $this->roleRepository->find($roleId);
        $role->permissions()->sync($permissionIds);
    }
}
