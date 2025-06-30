<?php

namespace App\Contracts\Users;

use App\DTOs\Status\StatusDTO;
use App\Models\User;

interface UserInterface
{
    public function find(int $userId): User;

    public function paginateWithRelations(int $perPage = 10);

    public function updateStatus(User $user, StatusDTO $status);

    public function assignRoles(User $user, array $rolesIds);

    public function delete(User $user);
}
