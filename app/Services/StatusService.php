<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Statuses\StatusInterface;
use App\DTOs\Status\StatusDTO;
use App\Models\Status;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final readonly class StatusService
{
    public function __construct(private StatusInterface $repository) {}

    private function toDto(Status $status): StatusDTO
    {
        return StatusDTO::fromModel($status);
    }

    /**
     * Get all statuses as a DTO array
     *
     * @return array<StatusDTO>
     */
    public function allStatuses(): array
    {
        return $this->repository->all()
            ->map(fn (Status $status) => $this->toDto($status))
            ->toArray();
    }

    /**
     * Get paginated statuses with metadata
     *
     * @return array{
     *     current_page: int,
     *     data: array<StatusDTO>,
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
    public function allStatusesPaginated(int $perPage = 15): array
    {
        $paginated = $this->repository->statusesPaginated($perPage);

        return [
            'current_page' => $paginated->currentPage(),
            'data' => $paginated->getCollection()
                ->map(fn (Status $status) => $this->toDto($status))
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
     * Find a status by ID
     *
     * @throws ModelNotFoundException
     */
    public function findOne(int $id): StatusDTO
    {
        return $this->toDto($this->repository->find($id));
    }

    /**
     * Create a new status
     */
    public function create(StatusDTO $dto): StatusDTO
    {
        $status = $this->repository->create($this->dtoToAttributes($dto));
        return $this->toDto($status);
    }

    /**
     * Update an existing status
     */
    public function update(Status $status, StatusDTO $dto): StatusDTO
    {
        $updatedStatus = $this->repository->update(
            $status,
            $this->dtoToAttributes($dto)
        );

        return $this->toDto($updatedStatus);
    }

    /**
     * Delete a status
     */
    public function delete(Status $status): bool
    {
        return $this->repository->delete($status);
    }

    /**
     * Convert DTO to database attributes
     *
     * @return array{name: string, slug: string, description: string}
     */
    private function dtoToAttributes(StatusDTO $dto): array
    {
        return [
            'name' => $dto->name,
            'slug' => $dto->slug,
            'description' => $dto->description,
        ];
    }
}
