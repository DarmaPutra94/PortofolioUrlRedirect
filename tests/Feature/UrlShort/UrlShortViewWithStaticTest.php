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
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use Tests\TestCase;

#[CoversClass(UrlShortController::class)]
#[UsesClass(User::class), UsesClass(UrlShortPolicy::class), UsesClass(AuthService::class), UsesClass(UrlShorterService::class), UsesClass(AuthController::class), UsesClass(UrlShort::class), UsesClass(UrlShortResource::class)]
class UrlShortViewWithStaticTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_get_shorturl_with_statistic(): void
    {
        $test_user = $this->generate_test_user();
        $short_url = $this->generate_test_url_short(User::find($test_user->user['id']));
        $response = $this->get(
            route('shorturl.show-with-statistic', ['short_code' => $short_url->short_code]),
            [
                'Accept' => 'application/json',
                'Authorization' => "Bearer " . $test_user->accessToken
            ]
        );
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "id",
            "url",
            "shortCode",
            "createdAt",
            "updatedAt",
            "accessCount"
        ]);
    }

    public function test_fail_get_shorturl_with_statistic_wrong_user(): void
    {
        $wrong_user = $this->generate_test_user();
        $correct_user = User::factory()->create();
        $short_url = $this->generate_test_url_short($correct_user);
        $response = $this->get(route('shorturl.show-with-statistic', ['short_code' => $short_url->short_code]), [
            'Accept' => 'application/json',
            'Authorization' => "Bearer " . $wrong_user->accessToken
        ]);
        $response->assertStatus(403);
    }

    public function test_fail_get_shorturl_with_statistic_unauthenticated_user(): void
    {
        $correct_user = User::factory()->create();
        $short_url = $this->generate_test_url_short($correct_user);
        $response = $this->get(route('shorturl.show-with-statistic', ['short_code' => $short_url->short_code]), [
            'Accept' => 'application/json',
        ]);
        $response->assertStatus(401);
    }

    public function test_fail_get_shorturl_with_statistic_invalid_shortcode(): void
    {
        $test_user = $this->generate_test_user();
        $response = $this->get(route('shorturl.show-with-statistic', ['short_code' => "FAILED"]),  [
            'Accept' => 'application/json',
            'Authorization' => "Bearer " . $test_user->accessToken
        ]);
        $response->assertStatus(404);
    }
}
