<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Permissions\PermissionInterface;
use App\DTOs\Permission\PermissionDTO;
use App\Models\Permission;

final readonly class PermissionService
{
    public function __construct(private PermissionInterface $repository) {}

    private function toDto(Permission $permission): PermissionDTO
    {
        return PermissionDTO::fromModel($permission);
    }

    public function allPermissions(): array
    {
        return $this->repository->all()
            ->map(fn (Permission $permission) => $this->toDto($permission))
            ->toArray();
    }

    public function findOne(int $id): PermissionDTO
    {
        return $this->toDto($this->repository->find($id));
    }

    public function create(PermissionDTO $dto): PermissionDTO
    {
        $permission = $this->repository->create([
            'name' => $dto->name,
            'slug' => $dto->slug,
        ]);

        return $this->toDto($permission);
    }

    public function update(Permission $permission, PermissionDTO $dto): PermissionDTO
    {
        $updatedPermission = $this->repository->update($permission, [
            'name' => $dto->name,
            'slug' => $dto->slug,
        ]);

        return $this->toDto($updatedPermission);
    }

    public function delete(Permission $permission): bool
    {
        return $this->repository->delete($permission);
    }
}
