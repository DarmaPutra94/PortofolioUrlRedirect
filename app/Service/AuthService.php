<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
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

    public function generateResetPasswordLink(String $email): String
    {
        return Password::sendResetLink(['email'=>$email]);
    }

    public function resetPassword(String $email, String $password, String $password_confirmation, String $token): mixed
    {
        $credentials = [
            'email'=>$email,
            'password'=>$password,
            'password_confirmation'=>$password_confirmation,
            'token'=> $token
        ];
        $status = Password::reset($credentials, function(User $user, string $password){
            $user->forceFill(['password'=>Hash::make($password)]);
            $user->save();
            event(new PasswordReset($user));
        });
        return $status;
    }

    public function create($data)
    {
        return User::create($data);
    }

    public function getUser(String $email): User{
        return User::where('email', $email)->first();
    }

    public function isValidUserCredential(User $user, String $password): bool{
        return Hash::check($password, $user->password);
    }

    // public function login($data){

    // }

    // public function retriveUser(User $user)
    // {
    //     $user = User::where('email', $data['email'])->firstOrFail();
    //     if (!Hash::check($data['password'], $user->password)) {
    //         abort(response()->json([
    //             'message' => 'Wrong credential',
    //         ], 401));
    //     }
    //     $user->tokens()->delete();
    //     return $user;
    // }


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
