<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Resources\User\UserProfileResource;

final class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ){}

    public function profile(): UserProfileResource
    {
        //Todo Code Example
        $user = $this->userService->profile(auth()->id());

        return UserProfileResource::make($user);
    }
}
