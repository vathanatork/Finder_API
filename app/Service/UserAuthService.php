<?php

namespace App\Service;

use App\Constants\Enum\UserRoleEnum;
use App\Http\Requests\Mobile\V01\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserAuthService
{
    private MediaService $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->getName(),
            'birthday' => $request->getBirthday(),
            'gender' => strtolower($request->getGender()),
            'email' => $request->getEmail(),
            'password' => Hash::make($request->getPassword()),
            'role'=> UserRoleEnum::USER
        ]);

        return $user;
    }

    public function generateUserToken($user,$role): ?string
    {
        if($role === 'mobile'){
            return $user->createToken('mobile', ['role:user'],now()->addHours(1))->plainTextToken;
        }

        if($role === 'admin'){
            return $user->createToken('admin', ['role:admin'],now()->addHours(1))->plainTextToken;
        }

        return null;
    }

    public function generateUserRefreshToken($user,$role): ?string
    {
        if($role === 'mobile'){
            return $user->createToken('mobile', ['refresh_token'],now()->addHours(2))->plainTextToken;
        }

        if($role === 'admin'){
            return $user->createToken('admin', ['refresh_token'],now()->addHours(2))->plainTextToken;
        }

        return null;
    }

}
