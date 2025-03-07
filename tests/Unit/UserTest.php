<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_creation()
    {
        $user = User::factory()->create([
            'name' => 'Elena Rocha',
            'email' => 'elena@email.com',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Elena Rocha',
            'email' => 'elena@email.com',
        ]);
    }
}