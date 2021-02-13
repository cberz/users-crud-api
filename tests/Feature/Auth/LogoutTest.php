<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends TestCase
{
  use RefreshDatabase;

  public function testUserCanLogoutSuccessfully()
  {
    $user = User::factory()->create();

    $this->assertDatabaseCount('users', 1);

    $response = $this->postJson('/api/login', [
      'email' => $user->email,
      'password' => 'password',
      'device_name' => 'api-test',
    ]);

    $token = $response->original['token'];

    $response = $this
      ->withHeaders([
        'Authorization' => "Bearer $token",
      ])
      ->postJson('/api/logout');

    $response->assertOk()
      ->assertJsonStructure([
        'message',
      ]);
  }
}
