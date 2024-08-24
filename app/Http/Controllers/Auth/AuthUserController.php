<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class AuthUserController extends Controller
{

    public function __construct(
        private readonly UserService $userService
    ){}

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->userService->create($request->validated());

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (auth()->attempt($credentials)) {
            $user = Auth::user();
            $user['token'] = $user->createToken('auth')->accessToken;
            return response()->json([
                'user' => $user
            ], 200);
        }
        return response()->json([
            'message' => 'Invalid credentials'
        ], 402);
    }

    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}
