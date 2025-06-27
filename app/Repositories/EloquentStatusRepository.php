<?php

namespace App\Repositories;

use App\Contracts\Statuses\StatusInterface;
use App\Models\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentStatusRepository implements StatusInterface
{
    protected Status $model;

    /**
     * The columns to select from the Status table
     */
    private const STATUS_LIST_COLUMNS = ['id', 'name', 'slug', 'description', 'created_at', 'updated_at'];

    public function __construct(Status $model)
    {
        $this->model = $model;
    }

    private function baseQuery(): Builder
    {
        return $this->model->query()->select(self::STATUS_LIST_COLUMNS)->orderBy('name');
    }

    public function all(): Collection
    {
        return $this->baseQuery()->get();
    }

    public function statusesPaginated(int $perPage): LengthAwarePaginator
    {
        return $this->baseQuery()->paginate($perPage)->withQueryString();
    }

    public function find(int $id): Status
    {
        return $this->baseQuery()->findOrFail($id);
    }

    public function create(array $data): Status
    {
        return $this->model->create($data);
    }

    public function update(Status $status, array $data): Status
    {
        $status->update($data);

        return $status->fresh();
    }

    public function delete(Status $status): bool
    {
        return $status->delete();
    }
}
