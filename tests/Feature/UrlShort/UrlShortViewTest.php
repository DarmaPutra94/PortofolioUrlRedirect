<?php

namespace Tests\Feature\UrlShort;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UrlShortViewTest extends TestCase
{
    use RefreshDatabase;

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
        $response->assertJson([
            "id" => true,
            "url" => true,
            "shortCode" => true,
            "createdAt" => true,
            "updatedAt" => true
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
