<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;

final class UserRepository
    extends BaseRepository
    implements UserRepositoryInterface
{
    public function __construct(
        User $model
    )
    {
        parent::__construct($model);
    }

    public function getByEmail(string $email): User | bool
    {
        $user = $this->model->where('email', $email);

        if($user->exists())
            return $user->first();

        return false;
    }
}