<?php

namespace App\Services;

use App\Contracts\UserInterface;
use App\Models\Status;
use App\Models\User;

class UserService
{
    public function __construct(
        private readonly UserInterface $userRepository,
    ) {}

    public function allUsers()
    {
        return $this->userRepository->paginateWithRelations();
    }

    public function updateStatus(User $user, Status $status)
    {
        $this->userRepository->updateStatus($user, $status);
    }

    public function assignRoles(User $user, array $rolesIds)
    {
        $this->userRepository->assignRoles($user, $rolesIds);
    }
}
