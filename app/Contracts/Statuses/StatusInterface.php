<?php

namespace App\Contracts\Statuses;

use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface StatusInterface
{
    public function all(): Collection;

    public function statusesPaginated(int $perPage): LengthAwarePaginator;

    public function find(int $id): Status;

    public function create(array $data): Status;

    public function update(Status $status, array $data): Status;

    public function delete(Status $status): bool;
}
