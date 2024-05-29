<?php

namespace App\Http\Controllers\Admin\V01;

use App\Constants\Enum\StatusCodeEnum;
use App\Constants\Enum\UserRoleEnum;
use App\Http\Requests\Mobile\V01\Auth\LoginRequest;
use App\Http\Resources\Mobile\UserRegisterResource;
use App\Models\User;
use App\Service\UserAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->getEmail())
            ->Where('role',UserRoleEnum::ADMIN)
            ->first();
        if (! $user || ! Hash::check($request->getPassword(), $user->password)) {
            return $this->returnError(__('The provided credentials are incorrect.'),StatusCodeEnum::UNAUTHORIZED);
        }

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Login successfully');
        $this->setResult('admin', new UserRegisterResource($user));
        $this->_createToken($user,"admin");
        return $this->returnResults();
    }

    public function refresh_token(): JsonResponse
    {
        $user = auth()->user();
        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Refresh token successfully');
        $this->_createToken($user,"admin");
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
