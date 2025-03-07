<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_registration()
    {
        $response = $this->post('/register', [
            'name' => 'Luis García',
            'email' => 'luis@email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticated();
    }

    public function test_user_login()
    {
        $user = User::factory()->create([
            'email' => 'luis@email.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'luis@email.com',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticatedAs($user);
    }
}