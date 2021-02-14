<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
  use RefreshDatabase;

  public function testAllUsersCanBeListedAsGuest()
  {
    User::factory(10)->create();

    $this->assertDatabaseCount('users',10);

    $response = $this->getJson('/api/users');

    $response->assertOk()
      ->assertJsonStructure([
        'data' => [
          [
            'avatar',
            'personal_id',
            'name',
            'lastname',
            'email',
            'age',
          ]
        ]
      ]);
  }

  public function testUsersCanBeDeletedByAuthenticatedUser()
  {
    $token = $this->authToken();

    $user = User::factory()->create();

    $this->assertDatabaseCount('users', 2);

    $response = $this->withHeaders([
      'Authorization' => "Bearer $token",
    ])
      ->deleteJson("/api/users/$user->id");

    $this->assertDatabaseCount('users', 1)
      ->assertDeleted($user)
      ->assertDatabaseMissing('users', [
        'id' => $user->id,
        'email' => $user->email,
      ]);

    $response->assertOk()
      ->assertExactJson([
        'message' => 'Resource deleted succesfully'
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
