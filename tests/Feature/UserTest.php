<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function testAllUsersCanBeListedAsGuest()
  {
    User::factory(10)->create();

    $this->assertDatabaseCount('users', 10);

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
            'date_of_birth',
            'age',
          ]
        ]
      ]);
  }

  public function testUsersCanBeDeletedByAuthenticatedUsers()
  {
    $token = $this->authToken();

    $user = User::factory()->create();

    $this->assertDatabaseCount('users', 2);

    $response = $this->withHeaders([
      'Authorization' => "Bearer $token",
    ])
      ->deleteJson("/api/users/$user->id");

    $response->assertOk()
      ->assertExactJson([
        'message' => 'Resource deleted succesfully'
      ]);

    $this->assertDatabaseCount('users', 1)
      ->assertDeleted($user)
      ->assertDatabaseMissing('users', [
        'id' => $user->id,
        'email' => $user->email,
      ]);
  }

  public function testUserInformationCanBeShownToAuthenticatedUsers()
  {
    $token = $this->authToken();

    $user = User::factory()->create();

    $this->assertDatabaseCount('users', 2);

    $response = $this->withHeaders([
      'Authorization' => "Bearer $token",
    ])
      ->getJson("/api/users/$user->id");

      $response->assertOk()
      ->assertJsonStructure([
        'data' => [
          'avatar',
          'personal_id',
          'name',
          'lastname',
          'email',
          'date_of_birth',
          'age',
        ]
      ]);
  }

  public function testSimpleUserCanBeCreatedByAuthenticatedUsers()
  {
    $token = $this->authToken();

    $this->assertDatabaseCount('users', 1);

    $response = $this->withHeaders([
      'Authorization' => "Bearer $token",
    ])
      ->postJson('/api/users/', [
        'personal_id' => $this->faker->randomNumber,
        'name' => $this->faker->firstName,
        'lastname'  => $this->faker->lastName,
        'date_of_birth'  => $this->faker->date,
        'email' => $this->faker->unique()->safeEmail,
      ]);

      $response->assertSuccessful()
        ->assertJsonStructure([
          'data' => [
            'personal_id',
            'avatar',
            'name',
            'lastname',
            'email',
            'date_of_birth',
            'age',
          ]
        ])
        ;

      $this->assertDatabaseCount('users', 2)
        ->assertDatabaseHas('users', [
          'id' => 2,
        ]);
  }

  public function testAdminUserCanBeCreatedByAuthenticatedUsers()
  {
    $token = $this->authToken();

    $this->assertDatabaseCount('users', 1);

    $response = $this->withHeaders([
      'Authorization' => "Bearer $token",
    ])
      ->postJson('/api/users/', [
        'personal_id' => $this->faker->randomNumber,
        'name' => $this->faker->firstName,
        'lastname'  => $this->faker->lastName,
        'date_of_birth'  => $this->faker->date,
        'email' => $this->faker->unique()->safeEmail,
        'is_admin' => 1,
        'password' => 'password',
        'password_confirmation' => 'password',
      ]);

      $response->assertSuccessful()
        ->assertJsonStructure([
          'data' => [
            'personal_id',
            'avatar',
            'name',
            'lastname',
            'email',
            'date_of_birth',
            'age',
          ]
        ])
        ;

      $this->assertDatabaseCount('users', 2)
        ->assertDatabaseHas('users', [
          'id' => 2,
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
