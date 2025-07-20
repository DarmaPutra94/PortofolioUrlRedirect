<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\AuthService;
use Illuminate\Auth\Events\PasswordResetLinkSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
        $data['password'] = Hash::make($data['password']);
        Auth::login($user);
        return redirect()->route('frontend.dashboard');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string']
        ]);
        $user = $this->auth_service_manager->getUser($data['email']);
        if (!$user || !$this->auth_service_manager->isValidUserCredential($user, $data['password'])) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect'],
                'password' => ['The provided credentials are incorrect']
            ]);
        };
        Auth::login($user);
        return redirect()->route('frontend.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('frontend.view-login');
    }

    public function requestResetPassword(Request $request)
    {
        $data = $request->validate(['email' => 'required|email|exists:users,email']);
        $status = $this->auth_service_manager->generateResetPasswordLink($data['email']);
        if ($status !== Password::ResetLinkSent) {
            throw ValidationException::withMessages([
                'email' => $status,
            ]);
        }
        return back()->with(['successMessage' => 'Reset password link sent to email!']);
    }

    public function resetPassword(Request $request, $token, $user_id)
    {
        $data = $request->validate([
            'password' => ['required', 'string', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ]);
        $user = User::find($user_id);
        if (!$user) {
            return back()->with(['errorMessage' => 'No user found, please access this page from your email.']);
        }
        $status = $this->auth_service_manager->resetPassword($user->email, $data['password'], $data['password_confirmation'], $token);
        if ($status !== Password::PasswordReset) {
            return back()->with(['errorMessage' => $status]);
        }
        return redirect(route('frontend.login'))->with(['successMessage' => 'Password has been changed!']);
    }

    public function requestResetPasswordView(Request $request)
    {
        return view('pages.requestresetpassword');
    }

    public function resetPasswordView(Request $request, $token, $user_id)
    {
        return view('pages.resetpassword', ['token' => $token, 'user_id' => $user_id]);
    }

    public function loginView(Request $request)
    {
        return view('pages.login');
    }

    public function registerView(Request $request)
    {
        return view('pages.register');
    }
}
