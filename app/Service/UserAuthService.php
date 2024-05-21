<?php

namespace App\Service;

use App\Http\Requests\Mobile\V01\RegisterRequest;
use App\Models\User;

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
            'email' => $request->getEmail(),
            'password' => $request->getPassword(),
        ]);

        return $user;
    }

    public function generateUserToken($user): string
    {
        return $user->createToken('mobile', ['role:user'],now()->addHours(1))->plainTextToken;
    }

    public function generateUserRefreshToken($user): string
    {
        return $user->createToken('mobile', ['refresh_token'],now()->addHours(2))->plainTextToken;
    }

}
