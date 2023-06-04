<?php

namespace App\Http\Controllers\Api;

use App\DTO\UserDTO;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends BaseController
{
    public function __construct(private readonly UserService $userService)
    {

    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $userDTO = new UserDTO(...$request->validated());
        $user = $this->userService->createUser($userDTO);

        return $this->sendResponse($user, 'Registration was a success!');
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $auth = $this->userService->authenticateUser($request->validated());

        if (! $auth) {
            return $this->sendError('Credentials does not match with our records.', Response::HTTP_UNAUTHORIZED);
        }

        /** @var User $user */
        $user = auth()->user();

        $response = [
            'user' => new UserResource($user),
            'jwt' => $user->createToken('token')->plainTextToken,
        ];

        return $this->sendResponse($response, 'You have been logged in!');
    }

    public function me(): JsonResponse
    {
        return $this->sendResponse(new UserResource(auth()->user()));
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->sendResponse(null, 'You have been logged out!');
    }
}
