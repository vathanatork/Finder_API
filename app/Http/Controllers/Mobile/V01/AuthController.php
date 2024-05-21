<?php

namespace App\Http\Controllers\Mobile\V01;

use App\Http\Requests\Mobile\V01\RegisterRequest;
use App\Http\Resources\Mobile\UserRegisterResource;
use App\Models\User;
use App\Service\UserAuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private UserAuthService $UserAuthService;

    public function __construct(UserAuthService $UserAuthService)
    {
        $this->UserAuthService = $UserAuthService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::where('email', $request->getEmail())->first();
        if (!empty($user)) {
            return $this->returnError(__('Email Already Registered.'), 409);
        }

        $user = $this->UserAuthService->register($request);
        $this->setCode(200);
        $this->setMessage('Registered in successfully');
        $this->setResult('user', new UserRegisterResource($user));
        $this->setResult('token', $this->UserAuthService->generateUserToken($user));
        $this->setResult('refresh_token', $this->UserAuthService->generateUserRefreshToken($user));
        return $this->returnResults();
    }

    public function refresh_token(): JsonResponse
    {
        $user = auth()->user();
        $this->setCode(200);
        $this->setMessage('Refresh token in successfully');
        $this->setResult('token', $this->UserAuthService->generateUserToken($user));
        $this->setResult('refresh_token', $this->UserAuthService->generateUserRefreshToken($user));
        return $this->returnResults();
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        $this->setCode(200);
        $this->setMessage('Logged out successfully');
        return $this->returnResults();
    }

}
