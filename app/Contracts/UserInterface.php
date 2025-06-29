<?php

namespace App\Contracts;

use App\Models\Status;
use App\Models\User;

interface UserInterface
{
    public function paginateWithRelations(int $perPage = 10);

    public function updateStatus(User $user, Status $status);

    public function assignRoles(User $user, array $rolesIds);
}
