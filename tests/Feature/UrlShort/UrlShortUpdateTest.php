<?php

namespace Tests\Feature\UrlShort;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UrlShortUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_update_shorturl(): void
    {
        $test_user = $this->generate_test_user();
        $short_url = $this->generate_test_url_short(User::find($test_user->user['id']));
        $response = $this->put(
            route('shorturl.update', ['short_code' => $short_url->short_code]),
            [
                'url' => 'https://roadmap.sh'
            ],
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

    public function test_fail_update_shorturl_invalid_param(): void
    {
        $test_user = $this->generate_test_user();
        $short_url = $this->generate_test_url_short(User::find($test_user->user['id']));
        $response = $this->put(
            route('shorturl.update', ['short_code' => $short_url->short_code]),
            [
                'orka' => 'test'
            ],
            [
                'Accept' => 'application/json',
                'Authorization' => "Bearer " . $test_user->accessToken
            ]
        );
        $response->assertStatus(422);
    }


    public function test_fail_update_shorturl_wrong_user(): void
    {
        $wrong_user = $this->generate_test_user();
        $correct_user = User::factory()->create();
        $short_url = $this->generate_test_url_short($correct_user);
        $response = $this->put(route('shorturl.update', ['short_code' => $short_url->short_code]), [
            'url' => 'https://roadmap.sh'
        ], [
            'Accept' => 'application/json',
            'Authorization' => "Bearer " . $wrong_user->accessToken
        ]);
        $response->assertStatus(403);
    }

    public function test_fail_update_shorturl_unauthenticated_user(): void
    {
        $correct_user = User::factory()->create();
        $short_url = $this->generate_test_url_short($correct_user);
        $response = $this->put(route('shorturl.update', ['short_code' => $short_url->short_code]), [
            'url' => 'https://roadmap.sh'
        ], [
            'Accept' => 'application/json',
        ]);
        $response->assertStatus(401);
    }

    public function test_fail_update_shorturl_invalid_shortcode(): void
    {
        $test_user = $this->generate_test_user();
        $response = $this->put(route('shorturl.update', ['short_code' => "FAILED"]), [
            'url' => 'https://roadmap.sh'
        ], [
            'Accept' => 'application/json',
            'Authorization' => "Bearer " . $test_user->accessToken
        ]);
        $response->assertStatus(404);
    }
}
