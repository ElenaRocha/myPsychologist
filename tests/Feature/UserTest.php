<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test para registrar un nuevo usuario.
     */
    public function test_user_registration()
    {
        $response = $this->post('/api/register', [
            'name' => 'Luis',
            'email' => 'luis@email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'telephone' => '1234567890',
        ]);

        $response->assertStatus(201);

        $this->assertAuthenticated();

        $data = $response->json();
        $token = $data['token'];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->get('/api/protected-route');

        $response->assertStatus(201);
    }

    /**
     * Test para iniciar sesión.
     */
    public function test_user_login()
    {
        $user = User::factory()->create([
            'email' => 'luis@email.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'luis@email.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    /**
     * Test para obtener el perfil del usuario autenticado.
     */
    public function test_get_user_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/perfil');

        $response->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);
    }

    /**
     * Test para actualizar el perfil del usuario autenticado.
     */
    public function test_update_user_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/perfil', [
            'name' => 'Nuevo Nombre',
            'email' => 'nuevo@email.com',
            'telephone' => '987654321',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Perfil actualizado correctamente',
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nuevo Nombre',
            'email' => 'nuevo@email.com',
            'telephone' => '987654321',
        ]);
    }

    /**
     * Test para eliminar un usuario.
     */
    public function test_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->deleteJson('/api/clientes/' . $user->id);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Usuario eliminado correctamente',
            ]);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    /**
     * Test para roles
     */
    public function test_admin_access_to_user_management()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $client = User::factory()->create(['role' => 'client']);

        $response = $this->actingAs($admin)->getJson('/api/usuarios');
        $response->assertStatus(200);

        $response = $this->actingAs($client)->getJson('/api/usuarios');
        $response->assertStatus(403);
    }

    /**
     * Test para comprobar que u cliente no puede eliminar a otro cliente
     */
    public function test_client_cannot_delete_another_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $client = User::factory()->create(['role' => 'client']);

        $response = $this->actingAs($client)->deleteJson("/api/usuarios/{$admin->id}");
        $response->assertStatus(403);
    }
}
