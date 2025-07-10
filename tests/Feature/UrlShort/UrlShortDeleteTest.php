<?php

namespace Tests\Feature\UrlShort;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UrlShortController;
use App\Models\UrlShort;
use App\Models\User;
use App\Policies\UrlShortPolicy;
use App\Service\AuthService;
use App\Service\UrlShorterService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use Tests\TestCase;

#[CoversClass(UrlShortController::class)]
#[UsesClass(User::class), UsesClass(UrlShort::class), UsesClass(UrlShortPolicy::class), UsesClass(AuthService::class), UsesClass(UrlShorterService::class), UsesClass(AuthController::class)]
class UrlShortDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_delete_shorturl(): void
    {
        try {
            $test_user = $this->generate_test_user();
            $short_url = $this->generate_test_url_short(User::find($test_user->user['id']));
            $response = $this->delete(route('shorturl.destroy', ['short_code' => $short_url->short_code]), [], [
                'Accept' => 'application/json',
                'Authorization' => "Bearer " . $test_user->accessToken
            ]);
            $response->assertStatus(204);
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function test_fail_delete_shorturl_wrong_user(): void
    {
        try {
            $wrong_user = $this->generate_test_user();
            $correct_user = User::factory()->create();
            $short_url = $this->generate_test_url_short($correct_user);
            $response = $this->delete(route('shorturl.destroy', ['short_code' => $short_url->short_code]), [], [
                'Accept' => 'application/json',
                'Authorization' => "Bearer " . $wrong_user->accessToken
            ]);
            $response->assertStatus(403);
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function test_fail_delete_shorturl_unauthenticated_user(): void
    {
        try {
            $correct_user = User::factory()->create();
            $short_url = $this->generate_test_url_short($correct_user);
            $response = $this->delete(route('shorturl.destroy', ['short_code' => $short_url->short_code]), [], [
                'Accept' => 'application/json',
            ]);
            $response->assertStatus(401);
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function test_fail_delete_shorturl_invalid_shortcode(): void
    {
        try {
            $test_user = $this->generate_test_user();
            $response = $this->delete(route('shorturl.destroy', ['short_code' => "FAILED"]), [], [
                'Accept' => 'application/json',
                'Authorization' => "Bearer " . $test_user->accessToken
            ]);
            $response->assertStatus(404);
        } catch (Exception $e) {
            dd($e);
        }
    }
}
