<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
  use RefreshDatabase;

  public function testAllUsersCanBeListed()
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
}
