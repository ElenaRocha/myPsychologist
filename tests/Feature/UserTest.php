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
        $response = $this->postJson('/api/register', [
            'name' => 'Luis García',
            'email' => 'luis@email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'telephone' => '123456789',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Usuario registrado exitosamente',
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Luis García',
            'email' => 'luis@email.com',
            'telephone' => '123456789',
        ]);
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
}
