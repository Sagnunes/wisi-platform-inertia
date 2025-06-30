<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Permissions\PermissionInterface;
use App\DTOs\Permission\PermissionDTO;
use App\DTOs\Role\RoleDTO;
use App\Models\Permission;
use App\Traits\PaginationTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final readonly class PermissionService
{
    use PaginationTrait;

    public function __construct(private PermissionInterface $repository)
    {
    }

    private function toDto(Permission $permission): PermissionDTO
    {
        return PermissionDTO::fromModel($permission);
    }

    /**
     * Get all roles as a DTO array
     *
     * @return array<RoleDTO>
     */
    public function allPermissions(): array
    {
        return $this->repository->all()
            ->map(fn(Permission $permission) => $this->toDto($permission))
            ->toArray();
    }

    /**
     * Get paginated statuses with metadata
     *
     * @return array{
     *     current_page: int,
     *     data: array<PermissionDTO>,
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
    public function allPermissionsPaginated(int $perPage = 15): array
    {
        $paginated = $this->repository->permissionsPaginated($perPage);

        return $this->formatPagination($paginated, fn(Permission $permission) => $this->toDto($permission));
    }

    /**
     * Find a permission by ID
     *
     * @throws ModelNotFoundException
     */
    public function findOne(int $id): PermissionDTO
    {
        return $this->toDto($this->repository->find($id));
    }

    /**
     * Create a new permission
     */
    public function create(PermissionDTO $dto): PermissionDTO
    {
        $permission = $this->repository->create($this->dtoToAttributes($dto));

        return $this->toDto($permission);
    }

    /**
     * Update a existing permission
     */
    public function update(Permission $permission, PermissionDTO $dto): PermissionDTO
    {
        $updatedPermission = $this->repository->update(
            $permission,
            $this->dtoToAttributes($dto)
        );

        return $this->toDto($updatedPermission);
    }

    /**
     * Delete a permission
     */
    public function delete(Permission $permission): bool
    {
        return $this->repository->delete($permission);
    }

    /**
     * Convert DTO to database attributes
     *
     * @return array{name: string, slug: string}
     */
    private function dtoToAttributes(PermissionDTO $dto): array
    {
        return [
            'name' => $dto->name,
            'slug' => $dto->slug,
        ];
    }
}
