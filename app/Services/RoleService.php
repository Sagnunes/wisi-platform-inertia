<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Roles\RoleInterface;
use App\DTOs\Role\RoleDTO;
use App\Models\Role;

final readonly class RoleService
{
    public function __construct(private RoleInterface $repository) {}

    /**
     * Convert a Role model to a RoleDTO.
     */
    private function toDto(Role $role): RoleDTO
    {
        return RoleDTO::fromModel($role);
    }

    /**
     * Get all roles as DTO array.
     *
     * @return array<RoleDTO>
     */
    public function allRoles(): array
    {
        return $this->repository->all()
            ->map(fn (Role $role) => $this->toDto($role))
            ->toArray();
    }

    /**
     * Get paginated roles with metadata.
     *
     * @return array{
     *     current_page: int,
     *     data: array<RoleDTO>,
     *     first_page_url: string,
     *     from: int,
     *     last_page: int,
     *     last_page_url: string,
     *     links: array,
     *     next_page_url: string|null,
     *     path: string,
     *     per_page: int,
     *     prev_page_url: string|null,
     *     to: int,
     *     total: int
     * }
     */
    public function allRolesPaginated(int $perPage = 15): array
    {
        $paginated = $this->repository->rolesPaginated($perPage);

        return [
            'current_page' => $paginated->currentPage(),
            'data' => $paginated->getCollection()
                ->map(fn (Role $role) => $this->toDto($role))
                ->all(),
            'first_page_url' => $paginated->url(1),
            'from' => $paginated->firstItem(),
            'last_page' => $paginated->lastPage(),
            'last_page_url' => $paginated->url($paginated->lastPage()),
            'links' => $paginated->linkCollection()->toArray(),
            'next_page_url' => $paginated->nextPageUrl(),
            'path' => $paginated->path(),
            'per_page' => $paginated->perPage(),
            'prev_page_url' => $paginated->previousPageUrl(),
            'to' => $paginated->lastItem(),
            'total' => $paginated->total(),
        ];
    }

    /**
     * Find a role by ID.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOne(int $id): RoleDTO
    {
        return $this->toDto($this->repository->find($id));
    }

    /**
     * Create a new role.
     */
    public function create(RoleDTO $dto): RoleDTO
    {
        $role = $this->repository->create($this->dtoToAttributes($dto));

        return $this->toDto($role);
    }

    /**
     * Update an existing role.
     */
    public function update(Role $role, RoleDTO $dto): RoleDTO
    {
        $updatedRole = $this->repository->update(
            $role,
            $this->dtoToAttributes($dto)
        );

        return $this->toDto($updatedRole);
    }

    /**
     * Delete a role.
     */
    public function delete(Role $role): bool
    {
        return $this->repository->delete($role);
    }

    /**
     * Convert RoleDTO to database attributes.
     *
     * @return array{name: string, slug: string, description: string}
     */
    private function dtoToAttributes(RoleDTO $dto): array
    {
        return [
            'name' => $dto->name,
            'slug' => $dto->slug,
            'description' => $dto->description,
        ];
    }
}
