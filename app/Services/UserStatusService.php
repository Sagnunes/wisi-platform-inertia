<?php

namespace App\Services;

use App\Contracts\Users\UserInterface;
use App\DTOs\Status\StatusDTO;
use App\Models\User;

final readonly class UserStatusService
{
    public function __construct(
        private UserInterface $userRepository,
    ) {}

    public function updateStatus(User $user, StatusDTO $status): bool
    {
        return $this->userRepository->updateStatus($user, $status);
    }
}
