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
        $response = $this->post('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'telephone' => '1234567890',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201);
        $this->assertAuthenticated();
    }

    public function test_user_login()
    {
        $user = User::factory()->create([
            'email' => 'luis@email.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/api/login', [
            'email' => 'luis@email.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);

        $data = $response->json();
        $token = $data['token'];

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->get(route('user.profile')); 

        $response->assertStatus(200);
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_registration_with_invalid_data()
    {
        $response = $this->post('/api/register', [
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

        $response = $this->post('/api/login', [
            'email' => 'luis@email.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401);
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_user_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $response = $this->post('/api/logout');

        $response->assertStatus(200);
        $this->assertGuest();
    }
}
