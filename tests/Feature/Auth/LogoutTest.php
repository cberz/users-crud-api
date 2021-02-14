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

    $token = $this->authToken();

    $this->assertDatabaseCount('users', 1);

    $response = $this->withHeaders([
      'Authorization' => "Bearer $token",
    ])
      ->postJson('/api/logout');

    $response->assertOk()
      ->assertExactJson([
        'message' => 'Successfully logged out',
      ]);
  }

  public function authToken()
  {
    $user = User::factory()->create();

    $response = $this->postJson('/api/login', [
      'email' => $user->email,
      'password' => 'password',
      'device_name' => 'api-test',
    ]);

    return $response['token'];
  }
}
