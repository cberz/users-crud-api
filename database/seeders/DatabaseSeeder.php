<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      User::factory()->create([
        'email' => 'test@demo.com',
        'is_admin' => 1
      ]);

      User::factory(6)->create();
    }
}
