<?php

namespace Tests\Feature\UrlShort;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UrlShortController;
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
#[UsesClass(User::class), UsesClass(UrlShortPolicy::class), UsesClass(AuthService::class), UsesClass(UrlShort::class), UsesClass(UrlShorterService::class), UsesClass(AuthController::class), UsesClass(UrlShortResource::class)]
class UrlShortViewTest extends TestCase
{
    use RefreshDatabase;


    public function test_success_shorturl_redirect(): void
    {

        $test_user = $this->generate_test_user();
        $short_url = $this->generate_test_url_short(User::find($test_user->user['id']));
        $response = $this->get(
            route('shorturl.redirect', ['short_code' => $short_url->short_code])
        );
        $response->assertStatus(302);
    }

    public function test_fail_shorturl_redirect_not_exist(): void
    {

        $test_user = $this->generate_test_user();
        $short_url = $this->generate_test_url_short(User::find($test_user->user['id']));
        $response = $this->get(
            route('shorturl.redirect', ['short_code' => "PUNGLIASD"])
        );
        $response->assertStatus(404);
    }

    public function test_success_get_user_shorturls(): void
    {

        $test_user = $this->generate_test_user();
        $this->generate_many_test_url_short(User::find($test_user->user['id']));
        $response = $this->get(
            route('shorturl.index'),
            [
                'Accept' => 'application/json',
                'Authorization' => "Bearer " . $test_user->accessToken
            ]
        );
        $response->assertStatus(200);
        $response->assertExactJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'url',
                    'shortCode',
                    'createdAt',
                    'updatedAt',
                ],
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next',
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links',
                'path',
                'per_page',
                'to',
                'total',
            ],
        ]);
    }

    public function test_success_wrong_user_get_empty_shorturls(): void
    {

        $test_user = $this->generate_test_user();
        $wrong_test_user = $this->generate_test_user();
        $this->generate_many_test_url_short(User::find($test_user->user['id']));
        $response = $this->get(
            route('shorturl.index'),
            [
                'Accept' => 'application/json',
                'Authorization' => "Bearer " . $wrong_test_user->accessToken
            ]
        );
        $response->assertStatus(200);
        $response->assertExactJsonStructure([
            'data' => [],
            'links' => [
                'first',
                'last',
                'prev',
                'next',
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links',
                'path',
                'per_page',
                'to',
                'total',
            ],
        ]);
    }

    public function test_success_get_shorturl(): void
    {

        $test_user = $this->generate_test_user();
        $short_url = $this->generate_test_url_short(User::find($test_user->user['id']));
        $response = $this->get(
            route('shorturl.show', ['short_code' => $short_url->short_code]),
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
            "updatedAt"
        ]);
    }

    public function test_fail_get_shorturl_wrong_user(): void
    {

        $wrong_user = $this->generate_test_user();
        $correct_user = User::factory()->create();
        $short_url = $this->generate_test_url_short($correct_user);
        $response = $this->get(route('shorturl.show', ['short_code' => $short_url->short_code]), [
            'Accept' => 'application/json',
            'Authorization' => "Bearer " . $wrong_user->accessToken
        ]);
        $response->assertStatus(403);
    }

    public function test_fail_get_shorturl_unauthenticated_user(): void
    {

        $correct_user = User::factory()->create();
        $short_url = $this->generate_test_url_short($correct_user);
        $response = $this->get(route('shorturl.show', ['short_code' => $short_url->short_code]), [
            'Accept' => 'application/json',
        ]);
        $response->assertStatus(401);
    }

    public function test_fail_get_shorturl_invalid_shortcode(): void
    {
        $test_user = $this->generate_test_user();
        $response = $this->get(route('shorturl.show', ['short_code' => "FAILED"]),  [
            'Accept' => 'application/json',
            'Authorization' => "Bearer " . $test_user->accessToken
        ]);
        $response->assertStatus(404);
    }
}
