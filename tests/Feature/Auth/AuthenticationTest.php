<?php

namespace Tests\Feature\Auth;

use App\Http\Controllers\AuthController;
use App\Models\User;
use App\Service\AuthService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PhpParser\Node\Stmt\Catch_;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use Tests\TestCase;

#[CoversClass(AuthController::class)]
#[UsesClass(User::class), UsesClass(AuthService::class)]
class AuthenticationTest extends TestCase
{
    use RefreshDatabase;


    public function test_success_user_can_register(): void
    {
        try {
            $response = $this->post(route('auth.register'), [
                'name' => 'TestGuy',
                'password' => 'password',
                'email' => 'test123@gmail.com'
            ]);
            $response->assertStatus(200);
            $response->assertJson([
                'user' => true,
                'accessToken' => true,
                'refreshToken' => true
            ]);
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function test_success_users_can_authenticate(): void
    {
        try {
            $user = User::factory()->create(['password' => 'password']);
            $response = $this->post(route('auth.login'), [
                'email' => $user->email,
                'password' => 'password',
            ], [
                'Accept' => 'application/json'
            ]);
            $response->assertStatus(200);
            $response->assertJson([
                'user' => true,
                'accessToken' => true,
                'refreshToken' => true
            ]);
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function test_fail_users_can_not_authenticate_with_invalid_password(): void
    {
        try {
            $user = User::factory()->create(['password' => 'password']);
            $response = $this->post(route('auth.login'), [
                'email' => $user->email,
                'password' => 'wrong-password',
            ], [
                'Accept' => 'application/json'
            ]);
            $response->assertStatus(401);
            $response->assertJson([
                'message' => true
            ]);
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function test_success_getting_new_access_token_with_valid_refresh_token(): void
    {
        try {
            $test_user = $this->generate_test_user();
            $response = $this->post(route('auth.refresh'), [], [
                'Accept' => 'application/json',
                'Authorization' => "Bearer " . $test_user->refreshToken
            ]);
            $response->assertStatus(200);
            $response->assertJson([
                'user' => true,
                'accessToken' => true,
                'refreshToken' => true
            ]);
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function test_fail_getting_new_access_token_with_expired_refresh_token(): void
    {
        try {
            $test_user = $this->generate_test_user();
            $logout_response = $this->post(route('auth.logout'), [], [
                'Accept' => 'application/json',
                'Authorization' => "Bearer " . $test_user->accessToken
            ]);
            $logout_response->assertStatus(200);
            $refresh_response = $this->post(route('auth.refresh'), [], [
                'Accept' => 'application/json',
                'Authorization' => "Bearer " . $test_user->refreshToken
            ]);
            $refresh_response->assertStatus(401);
            $refresh_response->assertJson([
                'message' => true
            ]);
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function test_fail_getting_new_access_token_with_invalid_refresh_token(): void
    {
        try {
            // $test_user = $this->generate_test_user();
            $refresh_response = $this->post(route('auth.refresh'), [], [
                'Accept' => 'application/json',
                'Authorization' => "Bearer INVALID TOKEN"
            ]);
            $refresh_response->assertStatus(401);
            $refresh_response->assertJson([
                'message' => true
            ]);
        } catch (Exception $e) {
            dd($e);
        }
    }
}
