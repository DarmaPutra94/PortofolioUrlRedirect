<?php

namespace Tests;

use App\Models\UrlShort;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function generate_test_user(): mixed
    {
        $user = User::factory()->create(['password' => "Test123"]);
        $response = $this->postJson(route('auth.login'), [
            "email" => $user->email,
            "password" => "Test123"
        ]);
        $json = (object) $response->json();
        return $json;
    }

    protected function generate_test_url_short(User $user): mixed
    {
        $short_url = UrlShort::factory()->for($user)->create();
        return $short_url;
    }

    protected function generate_many_test_url_short(User $user): mixed
    {
        $short_url = UrlShort::factory()->for($user)->count(3)->create();
        return $short_url;
    }
}
