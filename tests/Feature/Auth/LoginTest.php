<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
  use RefreshDatabase;

  public function testUserCanLoginWithValidCredentials()
  {
    $user = User::factory()->create();

    $this->assertDatabaseCount('users', 1);

    $response = $this->postJson('/api/login', [
      'email' => $user->email,
      'password' => 'password',
      'device_name' => 'api-test',
    ]);

    $response->assertOk()
      ->assertJsonStructure([
        'token'
      ]);
  }

  public function testUserCanNotLoginWithInvalidCredentials()
  {
    $user = User::factory()->create();

    $this->assertDatabaseCount('users', 1);

    $response = $this->postJson('/api/login', [
      'email' => $user->email,
      'password' => 'InvalidPassword',
      'device_name' => 'api-test',
    ]);

    $response->assertStatus(422)
      ->assertJsonValidationErrors([
        'email',
      ]);
  }
}
