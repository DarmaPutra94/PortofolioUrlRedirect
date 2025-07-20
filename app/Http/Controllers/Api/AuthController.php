<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Service\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

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
            'password' => ['required', 'string', 'confirmed']
        ]);
        $user = $this->auth_service_manager->create($data);
        return response()->json([
            "user" => $user,
            "accessToken" => $user->generatePlainTextAccessToken(),
            "refreshToken" => $user->generatePlainTextRefreshToken()
        ]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string']
        ]);
        $user = $this->auth_service_manager->getUser($data['email']);
        if(!$user || !$this->auth_service_manager->isValidUserCredential($user, $data['password'])){
            abort(response()->json([
                'message' => 'Wrong credential',
            ], 401));
        };
        $user->tokens()->delete();
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
