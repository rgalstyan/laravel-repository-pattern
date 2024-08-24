<?php

declare(strict_types=1);

namespace App\Repository;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function getByEmail(string $email);
}