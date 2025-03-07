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

    public function test_user_registration_with_invalid_data()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_user_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'luis@email.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'luis@email.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_user_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $response = $this->post('/logout');

        $response->assertStatus(302);
        $this->assertGuest();
    }
}
