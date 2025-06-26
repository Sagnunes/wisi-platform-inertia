<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Roles\RoleInterface;
use App\DTOs\Role\RoleDTO;
use App\Models\Role;

final readonly class RoleService
{
    public function __construct(private RoleInterface $repository) {}

    private function toDto(Role $role): RoleDTO
    {
        return RoleDTO::fromModel($role);
    }

    public function allRoles(): array
    {
        return $this->repository->all()
            ->map(fn (Role $role) => $this->toDto($role))
            ->toArray();
    }

    public function findOne(int $id): RoleDTO
    {
        return $this->toDto($this->repository->find($id));
    }

    public function create(RoleDTO $dto): RoleDTO
    {
        $role = $this->repository->create([
            'name' => $dto->name,
            'slug' => $dto->slug,
            'description' => $dto->description,
        ]);

        return $this->toDto($role);
    }

    public function update(Role $role, RoleDTO $dto): RoleDTO
    {
        $updatedRole = $this->repository->update($role, [
            'name' => $dto->name,
            'slug' => $dto->slug,
            'description' => $dto->description,
        ]);

        return $this->toDto($updatedRole);
    }

    public function delete(Role $role): bool
    {
        return $this->repository->delete($role);
    }
}
