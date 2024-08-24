<?php

namespace App\Services;

use App\Repository\UserRepositoryInterface;

final class UserService extends CRUDService
{
    public function __construct(
        protected readonly UserRepositoryInterface $userRepository
    ){}

    public function profile(int $userId): object
    {
        return $this->userRepository->find($userId);
    }
}