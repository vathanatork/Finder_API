<?php

namespace App\Http\Controllers\Mobile\V01;

use App\Constants\Enum\StatusCodeEnum;
use App\Http\Requests\Mobile\V01\Auth\LoginRequest;
use App\Http\Requests\Mobile\V01\Auth\RegisterRequest;
use App\Http\Resources\Mobile\UserRegisterResource;
use App\Models\User;
use App\Service\UserAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private UserAuthService $UserAuthService;

    public function __construct(UserAuthService $UserAuthService)
    {
        $this->UserAuthService = $UserAuthService;
    }
    private function _createToken ($user,$role):void
    {
            $this->setResult('token', $this->UserAuthService->generateUserToken($user,$role));
            $this->setResult('refresh_token', $this->UserAuthService->generateUserRefreshToken($user,$role));
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::where('email', $request->getEmail())->first();
        if (!empty($user)) {
            return $this->returnError(__('Email Already Registered.'), StatusCodeEnum::CONFLICT);
        }

        $user = $this->UserAuthService->register($request);
        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Registered in successfully');
        $this->setResult('user', new UserRegisterResource($user));
        $this->_createToken($user,'mobile');
        return $this->returnResults();
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->getEmail())->first();
        if (! $user || ! Hash::check($request->getPassword(), $user->password)) {
            return $this->returnError(__('The provided credentials are incorrect.'),StatusCodeEnum::UNAUTHORIZED);
        }

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Login successfully');
        $this->setResult('user', new UserRegisterResource($user));
        $this->_createToken($user,'mobile');
        return $this->returnResults();
    }

    public function refresh_token(): JsonResponse
    {
        $user = auth()->user();
        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Refresh token successfully');
        $this->_createToken($user,'mobile');
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
