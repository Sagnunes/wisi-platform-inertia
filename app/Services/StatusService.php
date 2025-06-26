<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Statuses\StatusInterface;
use App\DTOs\Status\StatusDTO;
use App\Models\Status;

final readonly class StatusService
{
    public function __construct(private StatusInterface $repository)
    {
    }


    private function toDto(Status $status): StatusDTO
    {
        return StatusDTO::fromModel($status);
    }

    public function allStatuses(): array
    {
        return $this->repository->all()
            ->map(fn(Status $status) => $this->toDto($status))
            ->toArray();
    }

    public function findOne(int $id): StatusDTO
    {
        return $this->toDto($this->repository->find($id));
    }

    public function create(StatusDTO $dto): StatusDTO
    {
        $role = $this->repository->create([
            'name' => $dto->name,
            'slug' => $dto->slug,
            'description' => $dto->description,
        ]);

        return $this->toDto($role);
    }

    public function update(Status $status, StatusDTO $dto): StatusDTO
    {
        $updatedStatus = $this->repository->update($status, [
            'name' => $dto->name,
            'slug' => $dto->slug,
            'description' => $dto->description,
        ]);
        return $this->toDto($updatedStatus);
    }

    public function delete(Status $status): bool
    {
        return $this->repository->delete($status);
    }
}
