<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\PersonalAccessToken;

class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function generateResetPasswordLink($data)
    {
        return Url::temporarySignedRoute(
            'generate-reset-password',
            now()->addMinutes(30),
            ['user' => $data['user_id']]
        );
    }

    public function resetPassword($data)
    {
        $user = User::findOrFail($data['user_id']);
        $user->update(['password' => $data['password']]);
        return [
            "user" => $user
        ];
    }

    public function register($data)
    {
        $user = User::create($data);
        return $user;
    }

    public function login($data)
    {
        $user = User::where('email', $data['email'])->firstOrFail();
        if (!Hash::check($data['password'], $user->password)) {
            abort(response()->json([
                'message' => 'Wrong credential',
            ], 401));
        }
        $user->tokens()->delete();
        return $user;
    }


    public function refreshAccessToken(String $currentRefreshToken)
    {
        $refreshToken = PersonalAccessToken::findToken($currentRefreshToken);
        if (!$refreshToken || $refreshToken->name !== "refreshToken" || !$refreshToken->can('auth:refresh') || !$refreshToken->expires_at || $refreshToken->expires_at->isPast()) {
            abort(response()->json([
                'message' => 'Refresh token is expired',
            ], 401));
        }
        $user = $refreshToken->tokenable;
        /**
         * @var User $user
         */
        $user->tokens()->delete();
        return $user;
    }
}
