<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Service\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $auth_service_manager;
    public function __construct()
    {
        $this->auth_service_manager = new AuthService();
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users', 'max:255'],
            'password' => ['required', 'string']
        ]);
        $user = $this->auth_service_manager->register($data);
        return response()->json([
            "user" => $user,
            "accessToken" => $user->generatePlainTextAccessToken(),
            "refreshToken" => $user->generatePlainTextRefreshToken()
        ]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string']
        ]);
        $user = $this->auth_service_manager->login($data);
        return response()->json([
            "user" => $user,
            "accessToken" => $user->generatePlainTextAccessToken(),
            "refreshToken" => $user->generatePlainTextRefreshToken()
        ]);
    }


    public function refresh(Request $request)
    {
        $currentRefreshToken = $request->bearerToken();
        $user = $this->auth_service_manager->refreshAccessToken($currentRefreshToken);
        return response()->json([
            "user" => $user,
            "accessToken" => $user->generatePlainTextAccessToken(),
            "refreshToken" => $user->generatePlainTextRefreshToken()
        ]);
    }

    public function logout(Request $request){
        /**
         * @var User $user
         */
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json($user);
    }
}
