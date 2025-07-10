<?php

namespace Tests\Feature\UrlShort;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UrlShortController;
use App\Http\Resources\UrlShortResource;
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
#[UsesClass(User::class), UsesClass(UrlShort::class), UsesClass(UrlShortPolicy::class), UsesClass(AuthService::class), UsesClass(UrlShorterService::class), UsesClass(AuthController::class), UsesClass(UrlShortResource::class)]
class UrlShortCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_create_new_url_short(): void
    {
        try {
        $test_user = $this->generate_test_user();
        $response = $this->post(route('shorturl.store'), [
            "url" => 'https://laravel.com/'
        ], [
            'Accept' => 'application/json',
            'Authorization' => "Bearer " . $test_user->accessToken
        ]);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            "id",
            "url",
            "shortCode",
            "createdAt",
            "updatedAt"
        ]);
                } catch (Exception $e) {
            dd($e);
        }
    }

    public function test_fail_create_new_url_short_with_invalid_parameter(): void
    {
        try {
        $test_user = $this->generate_test_user();
        $response = $this->post(route('shorturl.store'), [
            "fail" => fake()->url()
        ], [
            'Accept' => 'application/json',
            'Authorization' => "Bearer " . $test_user->accessToken
        ]);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors'
        ]);
                } catch (Exception $e) {
            dd($e);
        }
    }

    public function test_fail_success_create_new_url_short_with_nonauthenticated_user(): void
    {
        try {
        $response = $this->post(route('shorturl.store'), [
            "url" => fake()->url()
        ], [
            'Accept' => 'application/json',
        ]);
        $response->assertStatus(401);
                } catch (Exception $e) {
            dd($e);
        }
    }
}
