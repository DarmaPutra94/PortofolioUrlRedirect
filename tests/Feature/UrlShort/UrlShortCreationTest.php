<?php

namespace Tests\Feature\UrlShort;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UrlShortCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_create_new_url_short(): void
    {
        $test_user = $this->generate_test_user();
        $response = $this->post(route('shorturl.store'), [
            "url" => 'https://laravel.com/'
        ], [
            'Accept' => 'application/json',
            'Authorization' => "Bearer " . $test_user->accessToken
        ]);
        $response->assertStatus(201);
        $response->assertJson([
            "id" => true,
            "url" => true,
            "shortCode" => true,
            "createdAt" => true,
            "updatedAt" => true
        ]);
    }

    public function test_fail_create_new_url_short_with_invalid_parameter(): void
    {
        $test_user = $this->generate_test_user();
        $response = $this->post(route('shorturl.store'), [
            "fail" => fake()->url()
        ], [
            'Accept' => 'application/json',
            'Authorization' => "Bearer " . $test_user->accessToken
        ]);
        $response->assertStatus(422);
        $response->assertJson([
            'message' => true,
            'errors' => true
        ]);
    }

    public function test_fail_success_create_new_url_short_with_nonauthenticated_user(): void
    {
        $response = $this->post(route('shorturl.store'), [
            "url" => fake()->url()
        ], [
            'Accept' => 'application/json',
        ]);
        $response->assertStatus(401);
    }
}
